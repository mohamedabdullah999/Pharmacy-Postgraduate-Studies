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

    public function store(StorePgStudentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $student = PgStudent::create($request->only([
                'name', 'national_id', 'student_code', 'dob', 'birth_governorate',
                'current_address', 'mobile_number', 'email', 'current_job',
                'academic_degree', 'degree_year', 'degree_institution',
                'general_grade', 'specialization_grade'
            ]));

            $activationToken = Str::random(8);

            $enrollment = PgEnrollment::create([
                'pg_student_id' => $student->id,
                'program_type' => $request->program_type,
                'enrollment_start_date' => $request->enrollment_start_date ?? now()->toDateString(),
                'enrollment_duration_days' => 0,
                'activation_token' => $activationToken,
                'enroll_dept_approval_date' => $request->enroll_dept_approval_date,
                'enroll_studies_approval_date' => $request->enroll_studies_approval_date,
                'enroll_faculty_approval_date' => $request->enroll_faculty_approval_date,
                'enroll_univ_approval_date' => $request->enroll_univ_approval_date,
                'preliminary_courses_end_date' => $request->preliminary_courses_end_date,
                'reg_dept_approval_date' => $request->reg_dept_approval_date,
                'reg_studies_approval_date' => $request->reg_studies_approval_date,
                'reg_faculty_approval_date' => $request->reg_faculty_approval_date,
                'reg_univ_approval_date' => $request->reg_univ_approval_date,
                'thesis_title_ar' => $request->thesis_title_ar,
                'thesis_title_en' => $request->thesis_title_en,
            ]);

            if ($request->filled('supervisors')) {
                $enrollment->supervisors()->sync($request->supervisors);
            }
        });

        return redirect()->route('enrollments.index', $request->program_type)
            ->with('success', 'تم إنشاء سجل الطالب بنجاح وتوليد رمز التفعيل');
    }
    
}