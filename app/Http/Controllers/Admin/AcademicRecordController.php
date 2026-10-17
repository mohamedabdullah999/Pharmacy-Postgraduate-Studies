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
        $students = Student::select('id', 'full_name', 'national_id', 'student_code')->get();
        return view('admin.records.create', compact('students'));
    }

    public function store(Request $request, RegistrationExpiryService $expiryService)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'program_type' => 'required|in:pre_master,master,doctorate',
            'registration_start_date' => 'required|date',
            'registration_duration_days' => 'required|integer|min:1',
            'extension_days' => 'nullable|integer|min:0',
        ], [
            'student_id.required' => 'يجب اختيار الطالب.',
            'program_type.required' => 'نوع البرنامج مطلوب.',
            'registration_start_date.required' => 'تاريخ موافقة المجلس على القيد مطلوب.',
            'registration_duration_days.required' => 'مدة القيد بالأيام مطلوبة.',
        ]);

        DB::transaction(function () use ($validated) {
            $program = StudentProgram::create([
                'student_id' => $validated['student_id'],
                'program_type' => $validated['program_type'],
                'registration_start_date' => $validated['registration_start_date'],
                'registration_duration_days' => $validated['registration_duration_days'],
                'extension_days' => $validated['extension_days'] ?? 0,
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'تم إضافة السجل الأكاديمي بنجاح، وتم حساب تاريخ الانتهاء تلقائياً.');
    }
}