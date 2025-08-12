<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use App\Models\Branch;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class DataImportController extends Controller
{

    // public function storeStudent(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|string',
    //         'name' => 'required|string',
    //         'citizenship' => 'required|string',
    //         'nic_number' => 'required|string',
    //         'certificate_name' => 'required|string',
    //         'gender' => 'required|string',
    //         'contact_address' => 'nullable|string',
    //         'permanent_address' => 'nullable|string',
    //         'email' => 'nullable|email',
    //         'mobile' => 'nullable|string',
    //         'whatsapp' => 'nullable|string',
    //         'course_id' => 'required|integer',
    //         'branch_id' => 'required|integer',
    //         'batch_id' => 'required|integer',
    //     ]);

    //     Student::create([
    //         'student_id' => $request->student_id,
    //         'name' => $request->name,
    //         'citizenship' => $request->citizenship,
    //         'nic_number' => $request->nic_number,
    //         'certificate_name' => $request->certificate_name,
    //         'gender' => $request->gender,
    //         'contact_address' => $request->contact_address,
    //         'permanent_address' => $request->permanent_address,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile,
    //         'whatsapp' => $request->whatsapp,
    //         'course_id' => $request->course_id,
    //         'branch_id' => $request->branch_id,
    //         'batch_id' => $request->batch_id,
    //         'status' => 'registered',
    //         'isActive' => 1,
    //     ]);

    //     return redirect()->back()->with('message', 'Student added successfully.');
    // }

    //
    public function DataImportPage()
    {

        try {

            $course = Course::where('isActive', 1)->get();

            $branch = Branch::where('isActive', 1)->get();

            $batch = Batch::where('isActive', 1)->get();


            return view('data-import.dataImport', compact('course', 'branch', 'batch'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }



    public function importData(Request $request)
    {
        // Validate the request
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
            'course_id' => 'required',
            'branch_id' => 'required',
            'batch_id' => 'required',
        ]);

        if ($request->file('csv_file')) {
            $file = $request->file('csv_file');

            // Read the CSV file
            $csvData = array_map('str_getcsv', file($file));

            if (count($csvData) < 2) {
                return redirect()->back()->with('error', 'CSV file is empty or invalid.');
            }

            // Extract the header and remove BOM if present
            $header = array_shift($csvData); // Remove the header row

            // Remove BOM if it exists
            if (substr($header[0], 0, 1) === "\xEF") {
                $header = array_map(function ($field) {
                    return preg_replace('/^\xEF\xBB\xBF/', '', $field); // Remove BOM from each field
                }, $header);
            }

            // Define expected header fields
            $expectedHeader = ['student_id', 'name', 'nic', 'email', 'gender', 'contact_number', 'whatsapp_number', 'address', 'isFastTrack'];

            if ($header !== $expectedHeader) {
                return redirect()->back()->with('error', 'CSV header fields do not match the expected format.');
            }

            // Process each line
            foreach ($csvData as $index => $line) {
                // Trim all values to avoid leading/trailing spaces
                $row = array_map('trim', $line);

                // Check if there is sufficient data in the row
                if (count($row) < 8 || empty($row[1])) {
                    continue; // Skip rows with missing required data
                }

                // Fill missing columns with null values if they are not critical
                $row = array_pad($row, 8, null);

                // Insert into the students table
                try {
                    DB::table('students')->insert([
                        'student_id' => $row[0],
                        'name' => $row[1],
                        'nic' => $row[2],
                        'email' => $row[3],
                        'gender' => $row[4],
                        'contact_number' => $row[5],
                        'whatsapp_number' => $row[6],
                        'address' => $row[7],
                        'branch_id' => $request->branch_id,
                        'course_id' => $request->course_id,
                        'batch_id' => $request->batch_id,
                        'isFastTrack' => $row[8],
                        'status' => 'registered',
                        'isActive' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to import row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('message', 'Data imported successfully.');
        }

        return redirect()->back()->with('error', 'Please upload a valid CSV file.');
    }

    public function FilterStudentDetails()
    {

        try {

            $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
                ->join('courses', 'students.course_id', '=', 'courses.course_id')
                ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
                ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no')
                ->where('students.isActive', 1)
                ->where('status', 'registered')
                ->get();

            $course = Course::where('isActive', 1)->get();

            $branch = Branch::where('isActive', 1)->get();

            $batch = Batch::where('isActive', 1)->get();


            return view('certificate.FilterStudentDetails', compact('data', 'course', 'branch', 'batch'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function registeredFilterStudents(Request $request)
    {
        $query = DB::table('students')
            ->join('branches', 'students.branch_id', '=', 'branches.branch_id')
            ->join('courses', 'students.course_id', '=', 'courses.course_id')
            ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
            ->select(
                'students.*',
                'branches.branch_name',
                'courses.course_name',
                'batches.batch_no'
            )
            ->where('students.status', 'registered'); // Move filtering here

        // Apply filters if selected
        if ($request->branch_id) {
            $query->where('students.branch_id', $request->branch_id);
        }
        if ($request->course_id) {
            $query->where('students.course_id', $request->course_id);
        }
        if ($request->batch_id) {
            $query->where('students.batch_id', $request->batch_id);
        }
        if (isset($request->isFastTrack)) {
            $query->where('students.isFastTrack', $request->isFastTrack);
        }


        $students = $query->distinct()->get(); // Get records after filtering in SQL


        return response()->json($students);
    }

    public function ongoingFilterStudents(Request $request)
    {
        $query = DB::table('students')
            ->join('branches', 'students.branch_id', '=', 'branches.branch_id')
            ->join('courses', 'students.course_id', '=', 'courses.course_id')
            ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
            ->select(
                'students.*',
                'branches.branch_name',
                'courses.course_name',
                'batches.batch_no'
            )
            ->where('students.status', 'ongoing'); // Move filtering here

        // Apply filters if selected
        if ($request->branch_id) {
            $query->where('students.branch_id', $request->branch_id);
        }
        if ($request->course_id) {
            $query->where('students.course_id', $request->course_id);
        }
        if ($request->batch_id) {
            $query->where('students.batch_id', $request->batch_id);
        }
        if (isset($request->isFastTrack)) {
            $query->where('students.isFastTrack', $request->isFastTrack);
        }

        $students = $query->distinct()->get(); // Get records after filtering in SQL

        return response()->json($students);
    }

    public function certifiedFilterStudents(Request $request)
    {
        $query = DB::table('students')
            ->join('branches', 'students.branch_id', '=', 'branches.branch_id')
            ->join('courses', 'students.course_id', '=', 'courses.course_id')
            ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
            ->select(
                'students.*',
                'branches.branch_name',
                'courses.course_name',
                'batches.batch_no'
            )
            ->where('students.status', 'certified'); // Move filtering here

        // Apply filters if selected
        if ($request->branch_id) {
            $query->where('students.branch_id', $request->branch_id);
        }
        if ($request->course_id) {
            $query->where('students.course_id', $request->course_id);
        }
        if ($request->batch_id) {
            $query->where('students.batch_id', $request->batch_id);
        }
        if (isset($request->isFastTrack)) {
            $query->where('students.isFastTrack', $request->isFastTrack);
        }

        $students = $query->distinct()->get(); // Get records after filtering in SQL

        return response()->json($students);
    }




    public function updateStatus(Request $request)
    {
        $studentIds = $request->input('student_ids');

        if (empty($studentIds)) {
            return response()->json(['success' => false, 'message' => 'No students selected']);
        }

        // Update student status to "Ongoing"
        Student::whereIn('student_id', $studentIds)->update(['status' => 'ongoing']);

        return response()->json(['success' => true]);
    }

    // public function FilterStudentDetails(Request $request)
    // {
    //     try {
    //         $query = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
    //             ->join('courses', 'students.course_id', '=', 'courses.course_id')
    //             ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
    //             ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no')
    //             ->where('students.isActive', 1);

    //         // Apply filters if selected
    //         if ($request->has('branch') && !empty($request->branch)) {
    //             $query->where('branches.branch_name', $request->branch);
    //         }

    //         if ($request->has('course') && !empty($request->course)) {
    //             $query->where('courses.course_name', $request->course);
    //         }

    //         if ($request->has('batch') && !empty($request->batch)) {
    //             $query->where('batches.batch_no', $request->batch);
    //         }

    //         $data = $query->get()->map(function ($student) {
    //             $student->encoded_id = base64_encode($student->student_id);
    //             return $student;
    //         });

    //         if ($request->ajax()) {
    //             return response()->json(['data' => $data]);
    //         }

    //         $course = Course::where('isActive', 1)->get();
    //         $branch = Branch::where('isActive', 1)->get();
    //         $batch = Batch::where('isActive', 1)->get();

    //         return view('Layout.FilterStudentDetails', compact('data', 'course', 'branch', 'batch'));
    //     } catch (Exception $e) {
    //         app(ErrorLogController::class)->ShowError($e);
    //         return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    //     }
    // }


    //     public function FilterStudentDetails()
    // {
    //     // try {
    //         $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
    //             ->join('courses', 'students.course_id', '=', 'courses.course_id')
    //             ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
    //             ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no')
    //             ->where('students.isActive', 1)
    //             ->get()
    //             ->map(function ($student) {
    //                 // Encode student_id to make it URL-safe
    //                 $student->encoded_id = base64_encode($student->student_id);

    //                 return $student;
    //             });

    //         $course = Course::where('isActive', 1)->get();
    //         $branch = Branch::where('isActive', 1)->get();
    //         $batch = Batch::where('isActive', 1)->get();

    //         return view('Layout.FilterStudentDetails', compact('data', 'course', 'branch', 'batch'));


    //     // } catch (Exception $e) {
    //     //     app(ErrorLogController::class)->ShowError($e);
    //     //     return redirect()->back()->with('error', 'Something went wrong. Please try again');
    //     // }

    // }


}
