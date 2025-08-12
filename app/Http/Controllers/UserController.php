<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Course;



class UserController extends Controller
{


    public function Index()
    {
        //        session()->forget('role');
        //        session()->forget('id');
        //        session()->flush();
        //
        //        return view('home.login');
    }
    public function Dashboard()
    {

        try {
            $studentCount = Student::where('isActive', 1)->count();
            $batchCount = Batch::where('isActive', 1)->count();
            $branchCount = Branch::where('isActive', 1)->count();
            $courseCount = Course::where('isActive', 1)->count();

            return view('dashboard', compact('studentCount', 'batchCount', 'branchCount', 'courseCount'));
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }


    public function Login(Request $request)
    {



        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isActive' => 1])) {
            $id = Auth::user()->id;
            $role = Auth::user()->role;
            session()->put('id', $id);
            session()->put('role', $role);

            return redirect('/dashboard');
        } else {
            return view('home.login')->withErrors(['Incorrect Login Details', 'The Message']);
        }
    }
    public function Logout()
    {

        session()->forget('role');
        session()->forget('id');
        session()->flush();

        return redirect('/admin');
    }


    public function UserManagement()
    {

        // isactive 1
        $data = User::where('isActive', 1)->get();

        // dd($data);
        return view('user.userManagement', compact('data'));
    }
    public function AddUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'contact' => 'required|digits:10',
            'password' => 'required|string|min:5',
            'role' => 'required|string|in:Admin,Sales,Manager',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->isActive = 1;


        $user->save();
        return redirect()->back()->with('message', 'New User Added !');
    }

    public function ChangePasswordView($id)
    {
        return view('user.changePassword')->with('id', $id);
    }
    public function ChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:5|confirmed',
        ]);

        try {
            $user = User::findOrFail($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('message', 'Password changed successfully.');
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }
    public function DisableUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->isActive = 0;
            $user->save();

            return redirect()->back()->with('message', 'User disabled successfully.');
        } catch (Exception $e) {
            app(ErrorLogController::class)->ShowError($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }
}
