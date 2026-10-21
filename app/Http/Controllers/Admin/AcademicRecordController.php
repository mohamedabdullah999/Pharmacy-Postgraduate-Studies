<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentProgram;
use App\Services\RegistrationExpiryService;
use Illuminate\Support\Facades\DB;

class AcademicRecordController extends Controller
{
   public function create()
    {
        return view('admin.records.create');
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            // بيانات الطالب الشخصية والمؤهل
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|size:14|unique:students,national_id',
            'student_code' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'previous_qualification' => 'nullable|string|max:255',
            'qualification_year' => 'nullable|digits:4',
            'qualification_institution' => 'nullable|string|max:255',
            'overall_grade' => 'nullable|string|max:50',
            
            // بيانات البرنامج والقيد
            'program_type' => 'required|in:pre_master,master,doctorate',
            'department_enrollment_approval_date' => 'nullable|date',
            'postgraduate_enrollment_approval_date' => 'nullable|date',
            'faculty_enrollment_approval_date' => 'nullable|date',
            'university_enrollment_approval_date' => 'nullable|date',
            'registration_start_date' => 'required|date',
            'registration_duration_days' => 'required|integer|min:1',
            'extension_days' => 'nullable|integer|min:0',
            
            // بيانات الرسالة
            'thesis_title_ar' => 'nullable|string',
            'thesis_title_en' => 'nullable|string',
            'supervisory_committee_members_text' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. إنشاء الطالب أولاً
            $student = Student::create([
                'full_name' => $validated['full_name'],
                'national_id' => $validated['national_id'],
                'student_code' => $validated['student_code'] ?? null,
                'mobile' => $validated['mobile'] ?? null,
                'email' => $validated['email'] ?? null,
                'previous_qualification' => $validated['previous_qualification'] ?? null,
                'qualification_year' => $validated['qualification_year'] ?? null,
                'qualification_institution' => $validated['qualification_institution'] ?? null,
                'overall_grade' => $validated['overall_grade'] ?? null,
            ]);

            // 2. إنشاء السجل الأكاديمي المرتبط به فوراً
            StudentProgram::create([
                'student_id' => $student->id,
                'program_type' => $validated['program_type'],
                'department_enrollment_approval_date' => $validated['department_enrollment_approval_date'] ?? null,
                'postgraduate_enrollment_approval_date' => $validated['postgraduate_enrollment_approval_date'] ?? null,
                'faculty_enrollment_approval_date' => $validated['faculty_enrollment_approval_date'] ?? null,
                'university_enrollment_approval_date' => $validated['university_enrollment_approval_date'] ?? null,
                'registration_start_date' => $validated['registration_start_date'],
                'registration_duration_days' => $validated['registration_duration_days'],
                'extension_days' => $validated['extension_days'] ?? 0,
                'thesis_title_ar' => $validated['thesis_title_ar'] ?? null,
                'thesis_title_en' => $validated['thesis_title_en'] ?? null,
                'supervisory_committee_members_text' => $validated['supervisory_committee_members_text'] ?? null,
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'تم إضافة الطالب وسجله الأكاديمي بنجاح.');
    }

    public function edit(StudentProgram $program)
    {
        $program->load('student');
        return view('admin.records.edit', compact('program'));
    }

    public function update(Request $request, StudentProgram $program)
    {
        $validated = $request->validate([
            'program_type' => 'required|in:pre_master,master,doctorate',
            'registration_start_date' => 'required|date',
            'registration_duration_days' => 'required|integer|min:1',
            'thesis_title_ar' => 'nullable|string|max:255',
            'thesis_title_en' => 'nullable|string|max:255',
            'supervisory_committee_members_text' => 'nullable|string',
        ]);

        $program->update($validated);

        return redirect()->route('admin.records.show', $program)->with('success', 'تم تحديث بيانات السجل الأكاديمي بنجاح.');
    }


 
    public function destroy(StudentProgram $program)
    {
        $program->delete(); 

        return redirect()->route('admin.dashboard')->with('success', 'تم أرشفة السجل الأكاديمي بنجاح. يمكن استعادته لاحقاً.');
    }
}












