<?php

namespace App\Http\Controllers;

use App\Models\PgEnrollment;
use App\Models\PgStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PgEnrollmentController extends Controller
{
    public function index(Request $request, $programType)
    {
        if (!in_array($programType, ['pre_master', 'master', 'phd'])) {
            abort(404);
        }

        $query = PgEnrollment::with('student', 'supervisors')->where('program_type', $programType);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('national_id', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->paginate(15);

        return view('enrollments.index', compact('enrollments', 'programType'));
    }

    public function show(PgEnrollment $enrollment)
    {
        $this->authorize('view', $enrollment->student);

        $enrollment->load(['student', 'supervisors', 'extensions', 'suspensions', 'fees']);

        return view('enrollments.show', compact('enrollment'));
    }

    public function create($programType)
    {
        if (!in_array($programType, ['pre_master', 'master', 'phd'])) {
            abort(404);
        }

        return view('enrollments.create', compact('programType'));
    }
    
}