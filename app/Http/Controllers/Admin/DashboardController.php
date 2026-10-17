<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentProgram;
use Illuminate\Http\Request;
use App\Services\RegistrationExpiryService;

class DashboardController extends Controller
{
    public function index(RegistrationExpiryService $expiryService)
    {
        $programs = StudentProgram::with('student')->latest()->paginate(15);

        foreach ($programs as $program) {
            $program->expiry_info = $expiryService->calculateExpiry($program);
        }

        return view('admin.dashboard', compact('programs'));
    }
}

