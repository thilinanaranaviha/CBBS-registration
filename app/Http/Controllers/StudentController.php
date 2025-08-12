<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Branch;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class StudentController extends Controller
{

    public function storeStudent(Request $request)
{
    $request->validate([
        'student_id' => 'required|string',
        'name' => 'required|string',
        'citizenship' => 'required|string',
        'nic_number' => 'required|string',
        'certificate_name' => 'required|string',
        'gender' => 'required|string',
        'contact_address' => 'nullable|string',
        'permanent_address' => 'nullable|string',
        'email' => 'nullable|email',
        'mobile' => 'nullable|string',
        'whatsapp' => 'nullable|string',
        'course_id' => 'nullable|string',
        'branch_id' => 'nullable|string',
        'batch_id' => 'nullable|string',
    ]);

    \App\Models\Student::create([
        'student_id' => $request->student_id,
        'name' => $request->name,
        'citizenship' => $request->citizenship,
        'nic_number' => $request->nic_number,
        'certificate_name' => $request->certificate_name,
        'gender' => $request->gender,
        'contact_address' => $request->contact_address,
        'permanent_address' => $request->permanent_address,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'whatsapp' => $request->whatsapp,
        'course_id' => $request->course_id,
        'branch_id' => $request->branch_id,
        'batch_id' => $request->batch_id,
        'status' => 'registered',
        'isActive' => 1,
    ]);

    return redirect()->back()->with('message', 'Student added successfully.');
}

    public function studentManagement()
    {
        $data = \App\Models\Student::select(
            'students.*',
            'branches.branch_name',
            'courses.course_name',
            'batches.batch_no'
        )
            ->leftJoin('branches', 'students.branch_id', '=', 'branches.branch_id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.course_id')
            ->leftJoin('batches', 'students.batch_id', '=', 'batches.batch_id')
            ->where('students.isActive', 1)
            ->get();

        $branch = \App\Models\Branch::where('isActive', 1)->get();
        $course = \App\Models\Course::where('isActive', 1)->get();
        $batch = \App\Models\Batch::where('isActive', 1)->get();

        return view('student.studentManagement', compact('data', 'branch', 'course', 'batch'));
    }


    public function AddStudent(Request $request)
    {

        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'nic' => 'required|string|max:12',
                'contact_number' => 'required|digits:10',
                'whatsapp_number' => 'required|digits:10',
                'address' => 'required|string|max:255',
                'branch_id' => 'required',
                'course_id' => 'required',
                'batch_id' => 'required',

            ]);

            $student_id = $request->student_id;

            if (Student::where('student_id', '=', $student_id)->exists()) {
                return redirect()->back()->with('error', 'Student ID Already Exists');
            }

            $data = new Student();

            $data->student_id = $student_id;
            $data->name = $request->name;
            $data->nic = $request->nic;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->contact_number = $request->contact_number;
            $data->whatsapp_number = $request->whatsapp_number;
            $data->address = $request->address;
            $data->branch_id = $request->branch_id;
            $data->course_id = $request->course_id;
            $data->batch_id = $request->batch_id;

            $data->isActive = 1;
            $data->save();

            return redirect()->back()->with('message', 'Student Added Successfully');
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

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
    public function EditStudent(Request $request)
    {

        try {


            if (Student::where('student_id', $request->student_id)
                ->where('student_id', '!=', $request->student_id)
                ->where('isActive', 1)
                ->exists()
            ) {
                return redirect()->back()->with('error', 'Student Id Already Exists');
            }

            Student::where(['student_id' => $request->student_id])->update([
                'name' => $request->name,
                'nic' => $request->nic,
                'email' => $request->email,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
                'whatsapp_number' => $request->whatsapp_number,
                'address' => $request->address,
                'branch_id' => $request->branch_id,
                'course_id' => $request->course_id,
                'batch_id' => $request->batch_id,

            ]);


            return redirect()->back()->with('message', 'Student Edited Successfully');
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function DeleteStudent($id)
    {


        try {


            Student::where(['id' => $id])->update([
                'isActive' => 0,
            ]);


            return redirect()->back()->with('message', 'Student Deleted Successfully');
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    // SearchStudent
    public function SearchStudent(Request $request)
    {
        try {
            $search = $request->search;

            $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
                ->join('courses', 'students.course_id', '=', 'courses.course_id')
                ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
                ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no', 'batches.graduation_date')
                ->where(function ($query) use ($search) {
                    $query->where('students.student_id', $search)
                        ->orWhere('students.nic', $search);
                })
                ->where('students.isActive', 1) // Apply isActive filter after OR condition
                ->where('status', 'certified')
                ->get();

            return view('home.search', compact('data'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    // StudentDetails
    public function StudentDetails($student_id)
    {
        try {
            // Decode student ID
            $studentId = base64_decode($student_id);

            // Fetch student details
            $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
                ->join('courses', 'students.course_id', '=', 'courses.course_id')
                ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
                ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no', 'batches.graduation_date')
                ->where('students.student_id', $studentId)
                ->where('students.isActive', 1)
                ->where('status', 'certified')
                ->get();
            // dd($data);


            return view('home.StudentDetails', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function getStudents(Request $request)
    {


        // Return Blade view for non-AJAX requests
        return view('certificate.FilterStudentDetails', compact('students', 'courses', 'branches', 'batches'));
    }


    // public function certificateload()
    // {
    //     return view('Layout.certificateload');
    // }

    public function certificateLoad(Request $request)
    {
        $studentIds = explode(',', $request->query('students'));

        // Update student status to "ongoing"
        Student::whereIn('student_id', $studentIds)->update(['status' => 'ongoing']);

        // Fetch students with joined data
        $students = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
            ->join('courses', 'students.course_id', '=', 'courses.course_id')
            ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
            ->select(
                'students.*',
                'branches.branch_name',
                'courses.course_name',
                'batches.batch_no',
                'batches.year_month',
                'batches.graduation_date',
                'branches.tvec_code'
            )
            ->whereIn('students.student_id', $studentIds)
            ->where('students.isActive', 1)
            ->where('status', 'ongoing')
            ->get()
            ->map(function ($student) {
                // Encode student_id to make it URL-safe
                $student->encoded_id = base64_encode($student->student_id);

                return $student;
            });


        // Load certificate images based on the course
        foreach ($students as $student) {

            if ($student->isFastTrack == 1) {
                if ($student->course_name === 'Basic Certificate for Barista') {
                    $student->barista_certificate = asset('assets/images/certificates/barista-fast-track.PNG');
                    $student->food_certificate = asset('assets/images/certificates/food-fast-track.PNG');
                    $courseName = $student->course_name;
                } elseif ($student->course_name === 'Basic Certificate for Bartender') {
                    $student->bartender_certificate = asset('assets/images/certificates/bartender-fast-track.PNG');
                    $student->food_certificate = asset('assets/images/certificates/food-fast-track.PNG');
                    $courseName = $student->course_name;
                }
            } else {
                if ($student->course_name === 'Basic Certificate for Barista') {
                    $student->barista_certificate = asset('assets/images/certificates/barista.PNG');
                    $student->food_certificate = asset('assets/images/certificates/food.PNG');
                    $courseName = $student->course_name;
                } elseif ($student->course_name === 'Basic Certificate for Bartender') {
                    $student->bartender_certificate = asset('assets/images/certificates/bartender.PNG');
                    $student->food_certificate = asset('assets/images/certificates/food.PNG');
                    $courseName = $student->course_name;
                }
            }
        }

        return view('certificate.certificateLoad', compact('students', 'courseName'));
    }


    public function ongoingStudentDetails()
    {
        try {

            $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
                ->join('courses', 'students.course_id', '=', 'courses.course_id')
                ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
                ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no')
                ->where('students.isActive', 1)
                ->where('status', 'ongoing')
                ->get();

            $course = Course::where('isActive', 1)->get();

            $branch = Branch::where('isActive', 1)->get();

            $batch = Batch::where('isActive', 1)->get();


            return view('certificate.ongoingStudentDetails', compact('data', 'course', 'branch', 'batch'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function certifiedStudentDetails()
    {
        try {

            $data = Student::join('branches', 'students.branch_id', '=', 'branches.branch_id')
                ->join('courses', 'students.course_id', '=', 'courses.course_id')
                ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
                ->select('students.*', 'branches.branch_name', 'courses.course_name', 'batches.batch_no')
                ->where('students.isActive', 1)
                ->where('status', 'certified')
                ->get();

            $course = Course::where('isActive', 1)->get();

            $branch = Branch::where('isActive', 1)->get();

            $batch = Batch::where('isActive', 1)->get();


            return view('certificate.certifiedStudentDetails', compact('data', 'course', 'branch', 'batch'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    // public function updateStatus(Request $request)
    // {
    //     $studentIds = $request->input('student_ids');

    //     if (empty($studentIds)) {
    //         return response()->json(['success' => false, 'message' => 'No students selected']);
    //     }

    //     // Update student status to "Ongoing"
    //     Student::whereIn('student_id', $studentIds)->update(['status' => 'ongoing']);

    //     return response()->json(['success' => true]);
    // }

    public function updateStatuscertified(Request $request)
    {
        $studentIds = $request->input('student_ids');

        if (empty($studentIds)) {
            return response()->json(['success' => false, 'message' => 'No students selected']);
        }

        // Update student status to "Ongoing"
        Student::whereIn('student_id', $studentIds)->update(['status' => 'certified']);

        return response()->json(['success' => true]);
    }

    public function updateStatusongoing(Request $request)
    {
        $studentIds = $request->input('student_ids');

        if (empty($studentIds)) {
            return response()->json(['success' => false, 'message' => 'No students selected']);
        }

        // Update student status to "Ongoing"
        Student::whereIn('student_id', $studentIds)->update(['status' => 'ongoing']);

        return response()->json(['success' => true]);
    }

    public function updateStatusbackregistered(Request $request)
    {
        $studentIds = $request->input('student_ids');

        if (empty($studentIds)) {
            return response()->json(['success' => false, 'message' => 'No students selected']);
        }

        // Update student status to "Ongoing"
        Student::whereIn('student_id', $studentIds)->update(['status' => 'registered']);

        return response()->json(['success' => true]);
    }
}
