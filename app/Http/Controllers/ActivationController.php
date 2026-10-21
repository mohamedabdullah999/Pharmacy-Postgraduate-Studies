<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateAccountRequest;
use App\Models\PgEnrollment;
use App\Models\PgStudent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActivationController extends Controller
{
    public function showForm()
    {
        return view('auth.activate');
    }

    public function activate(ActivateAccountRequest $request)
    {
        $student = PgStudent::where('national_id', $request->national_id)->first();

        if (!$student) {
            return back()->withErrors(['activation' => 'بيانات التفعيل غير صحيحة'])->withInput();
        }

        $enrollment = PgEnrollment::where('pg_student_id', $student->id)
            ->where('activation_token', $request->activation_token)
            ->first();

        if (!$enrollment) {
            return back()->withErrors(['activation' => 'بيانات التفعيل غير صحيحة'])->withInput();
        }

        if ($student->user_id) {
            return back()->withErrors(['activation' => 'هذا الحساب مفعل بالفعل'])->withInput();
        }

        DB::transaction(function () use ($request, $student, $enrollment) {
            $user = User::create([
                'name' => $student->name,
                'username' => $request->username,
                'email' => $student->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            $student->update(['user_id' => $user->id]);
            $enrollment->update(['activation_token' => null]);
        });

        return redirect()->route('login')->with('success', 'تم تفعيل الحساب بنجاح، يمكنك تسجيل الدخول الآن');
    }
}