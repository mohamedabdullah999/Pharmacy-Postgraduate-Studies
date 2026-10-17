<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivationRequest;
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

    public function activate(ActivationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $activationRecord = DB::table('activation_codes')
                ->where('national_id', $request->national_id)
                ->where('code', $request->activation_code)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$activationRecord) {
                return back()->withErrors(['activation_code' => 'كود التفعيل غير صحيح أو منتهي الصلاحية.']);
            }

            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->role = $activationRecord->role;
            $user->is_active = true;

            if ($activationRecord->role === 'student') {
                $student = Student::where('national_id', $request->national_id)->first();
                if (!$student) {
                    return back()->withErrors(['national_id' => 'بيانات الطالب غير موجودة بالنظام.']);
                }
                $user->student_id = $student->id;
            } elseif ($activationRecord->role === 'supervisor') {
                $supervisor = Supervisor::where('national_id', $request->national_id)->first();
                if (!$supervisor) {
                    return back()->withErrors(['national_id' => 'بيانات المشرف غير موجودة بالنظام.']);
                }
                $user->supervisor_id = $supervisor->id;
            }

            $user->save();

            DB::table('activation_codes')
                ->where('id', $activationRecord->id)
                ->update(['is_used' => true]);

            return redirect()->route('login')->with('success', 'تم تفعيل الحساب بنجاح، يمكنك تسجيل الدخول الآن.');
        });
    }
}