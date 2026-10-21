<?php

namespace App\Http\Controllers;

use App\Models\PgEnrollment;
use App\Models\PgExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PgExtensionController extends Controller
{
    public function store(Request $request, PgEnrollment $enrollment)
    {
        $this->authorize('update', $enrollment->student);

        $request->validate([
            'reason' => 'required|string|max:255',
            'dept_approval_date' => 'nullable|date',
            'studies_approval_date' => 'nullable|date',
            'faculty_approval_date' => 'nullable|date',
            'univ_approval_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $enrollment) {
            $nextExtensionNumber = $enrollment->extensions()->count() + 1;

            if ($nextExtensionNumber > 5) {
                abort(400, 'لا يمكن إضافة أكثر من 5 مدود.');
            }

            PgExtension::create([
                'pg_enrollment_id' => $enrollment->id,
                'extension_number' => $nextExtensionNumber,
                'reason' => $request->reason,
                'dept_approval_date' => $request->dept_approval_date,
                'studies_approval_date' => $request->studies_approval_date,
                'faculty_approval_date' => $request->faculty_approval_date,
                'univ_approval_date' => $request->univ_approval_date,
            ]);
            
        });

        return back()->with('success', 'تمت إضافة حركة المد بنجاح.');
    }
}