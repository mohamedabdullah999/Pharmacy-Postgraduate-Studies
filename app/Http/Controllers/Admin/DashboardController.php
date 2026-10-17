<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgram;
use App\Services\RegistrationExpiryService;

class DashboardController extends Controller
{
    public function index(Request $request, RegistrationExpiryService $expiryService)
    {
        $query = StudentProgram::with('student');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program_type')) {
            $query->where('program_type', $request->input('program_type'));
        }

        $programs = $query->latest()->paginate(15)->withQueryString();

        $statusFilter = $request->input('expiry_status');

        $filteredPrograms = collect();

        foreach ($programs as $program) {
            $program->expiry_info = $expiryService->calculateExpiry($program);
            
            if ($statusFilter) {
                if ($program->expiry_info['status'] === $statusFilter) {
                    $filteredPrograms->push($program);
                }
            } else {
                $filteredPrograms->push($program);
            }
        }

        if ($statusFilter) {
            $programs->setCollection($filteredPrograms);
        }

        return view('admin.dashboard', compact('programs'));
    }
}