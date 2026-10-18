<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgram;
use App\Models\ProgramExtension;
use App\Models\ProgramSuspension;
use App\Models\ProgramFeePayment;
use Illuminate\Support\Facades\DB;

class AcademicOperationsController extends Controller
{
    public function show(StudentProgram $program)
    {
        $program->load(['student', 'extensions', 'suspensions', 'feePayments']);
        return view('admin.records.show', compact('program'));
    }

    public function storeExtension(Request $request, StudentProgram $program)
    {
        $validated = $request->validate([
            'extension_number' => 'required|integer|min:1|max:5',
            'reason' => 'required|string',
            'granted_days' => 'required|integer|min:1',
            'university_council_approval_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($validated, $program) {
            ProgramExtension::updateOrCreate(
                ['student_program_id' => $program->id, 'extension_number' => $validated['extension_number']],
                [
                    'reason' => $validated['reason'],
                    'granted_days' => $validated['granted_days'],
                    'university_council_approval_date' => $validated['university_council_approval_date']
                ]
            );

            $totalExtensions = $program->extensions()->sum('granted_days');
            $program->update(['extension_days' => $totalExtensions]);
        });

        return redirect()->route('admin.records.show', $program)->with('success', 'تم إضافة المد بنجاح وتحديث تاريخ الانتهاء تلقائياً.');
    }

    public function storeSuspension(Request $request, StudentProgram $program)
    {
        $validated = $request->validate([
            'suspension_number' => 'required|integer|min:1|max:5',
            'reason' => 'required|string',
            'university_council_approval_date' => 'nullable|date',
        ]);

        ProgramSuspension::updateOrCreate(
            ['student_program_id' => $program->id, 'suspension_number' => $validated['suspension_number']],
            $validated
        );

        return redirect()->route('admin.records.show', $program)->with('success', 'تم تسجيل إيقاف القيد بنجاح.');
    }
}