<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\RegistrationExpiryService;

class DashboardController extends Controller
{
    public function index(RegistrationExpiryService $expiryService)
    {
        $student = Auth::user()->student()->with('programs')->firstOrFail();
        
        foreach ($student->programs as $program) {
            $program->expiry_info = $expiryService->calculateExpiry($program);
        }

        return view('student.dashboard', compact('student'));
    }
}