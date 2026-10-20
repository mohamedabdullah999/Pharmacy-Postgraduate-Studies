<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgram;

class FeePaymentController extends Controller
{
    public function store(Request $request, StudentProgram $program)
    {
        $validated = $request->validate([
            'fee_type' => 'required|in:tuition,extension,suspension',
            'period_number' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'receipt_number' => 'required|string|max:255',
        ]);

        $program->feePayments()->create($validated);

        return redirect()->route('admin.records.show', $program)->with('success', 'تم إضافة السجل المالي (الإيصال) بنجاح.');
    }
}