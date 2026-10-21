<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Supervisor;

class ActivationController extends Controller
{
    public function showActivationForm()
    {
        return view('auth.activate');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|size:14',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        return DB::transaction(function () use ($request) {
            $student = Student::where('national_id', $request->national_id)->first();
            $supervisor = null;
            $role = 'student';

            if (!$student) {
                $supervisor = Supervisor::where('national_id', $request->national_id)->first();
                $role = 'supervisor';
            }

            if (!$student && !$supervisor) {
                return back()->withErrors(['national_id' => 'الرقم القومي غير مسجل في قاعدة بيانات النظام. يرجى مراجعة إدارة الدراسات العليا.']);
            }

            if ($student && User::where('student_id', $student->id)->exists()) {
                return back()->withErrors(['national_id' => 'هذا الطالب لديه حساب مفعل بالفعل. يرجى تسجيل الدخول.']);
            }

            if ($supervisor && User::where('supervisor_id', $supervisor->id)->exists()) {
                return back()->withErrors(['national_id' => 'هذا المشرف لديه حساب مفعل بالفعل. يرجى تسجيل الدخول.']);
            }

            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $role,
                'is_active' => true,
                'student_id' => $student ? $student->id : null,
                'supervisor_id' => $supervisor ? $supervisor->id : null,
            ]);

            return redirect()->route('login')->with('success', 'تم تفعيل الحساب بنجاح، يمكنك تسجيل الدخول الآن.');
        });
    }
}