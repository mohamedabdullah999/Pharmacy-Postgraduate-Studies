<?php

namespace App\Http\Controllers;

use App\Models\PgSupervisor;
use App\Models\PgEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PgSupervisorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', PgSupervisor::class);

        $query = PgSupervisor::withCount('enrollments');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('national_id', 'like', '%' . $request->search . '%');
        }

        $supervisors = $query->paginate(15);

        return view('supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        $this->authorize('create', PgSupervisor::class);
        return view('supervisors.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', PgSupervisor::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|size:14|unique:pg_supervisors,national_id',
        ]);

        PgSupervisor::create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'activation_token' => Str::random(8),
        ]);

        return redirect()->route('supervisors.index')->with('success', 'تم تسجيل المشرف بنجاح وتوليد كود التفعيل.');
    }

    public function show(PgSupervisor $supervisor)
    {
        $this->authorize('view', $supervisor);
        
        $supervisor->load(['enrollments.student']);
        
        $availableEnrollments = PgEnrollment::with('student')
            ->whereDoesntHave('supervisors', function ($query) use ($supervisor) {
                $query->where('pg_supervisors.id', $supervisor->id);
            })->get();

        return view('supervisors.show', compact('supervisor', 'availableEnrollments'));
    }

    public function assignStudents(Request $request, PgSupervisor $supervisor)
    {
        $this->authorize('update', $supervisor);

        $request->validate([
            'enrollment_ids' => 'required|array',
            'enrollment_ids.*' => 'exists:pg_enrollments,id',
        ]);

        $supervisor->enrollments()->syncWithoutDetaching($request->enrollment_ids);

        return back()->with('success', 'تم ربط الطلاب بالمشرف بنجاح.');
    }

    public function removeStudent(PgSupervisor $supervisor, PgEnrollment $enrollment)
    {
        $this->authorize('update', $supervisor);

        $supervisor->enrollments()->detach($enrollment->id);

        return back()->with('success', 'تم إلغاء ارتباط الطالب بالمشرف.');
    }
}