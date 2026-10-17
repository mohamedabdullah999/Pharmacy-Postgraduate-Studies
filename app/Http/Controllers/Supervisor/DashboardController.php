<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\RegistrationExpiryService;

class DashboardController extends Controller
{
    public function index(RegistrationExpiryService $expiryService)
    {
        $supervisor = Auth::user()->supervisor()->with('students.programs')->firstOrFail();
        
        foreach ($supervisor->students as $student) {
            foreach ($student->programs as $program) {
                $program->expiry_info = $expiryService->calculateExpiry($program);
            }
        }

        return view('supervisor.dashboard', compact('supervisor'));
    }
}