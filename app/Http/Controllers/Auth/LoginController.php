<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['username' => 'الحساب غير مفعل. يرجى تفعيل الحساب أولاً.']);
            }

            $nationalIdMatch = false;
            
            if ($user->role === 'student' && $user->student) {
                $nationalIdMatch = $user->student->national_id === $request->national_id;
            } elseif ($user->role === 'supervisor' && $user->supervisor) {
                $nationalIdMatch = $user->supervisor->national_id === $request->national_id;
            } elseif ($user->role === 'admin') {
                $nationalIdMatch = true; 
            }

            if (!$nationalIdMatch) {
                Auth::logout();
                return back()->withErrors(['national_id' => 'الرقم القومي غير مطابق للحساب.']);
            }

            $request->session()->regenerate();
            $user->update(['last_login_at' => now()]);

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors(['username' => 'بيانات الدخول غير صحيحة.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            default => redirect('/'),
        };
    }
}