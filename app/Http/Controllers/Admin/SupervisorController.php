<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = Supervisor::withCount('students')->paginate(15);
        return view('admin.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        return view('admin.supervisors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|unique:supervisors,national_id',
        ], [
            'full_name.required' => 'اسم المشرف مطلوب.',
            'national_id.required' => 'الرقم القومي مطلوب.',
            'national_id.unique' => 'الرقم القومي مسجل مسبقاً لمشرف آخر.',
        ]);

        Supervisor::create($validated);

        return redirect()->route('admin.supervisors.index')->with('success', 'تم إضافة المشرف بنجاح.');
    }

    public function assignForm(Supervisor $supervisor)
    {
        $assignedStudentIds = $supervisor->students()->pluck('students.id');
        $students = Student::whereNotIn('id', $assignedStudentIds)->get();
        
        return view('admin.supervisors.assign', compact('supervisor', 'students'));
    }

    public function assignStudent(Request $request, Supervisor $supervisor)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        $supervisor->students()->attach($request->student_id, [
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->route('admin.supervisors.index')->with('success', 'تم تعيين الطالب للمشرف بنجاح.');
    }
}