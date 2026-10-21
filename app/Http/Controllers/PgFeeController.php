<?php

namespace App\Http\Controllers;

use App\Models\PgEnrollment;
use App\Models\PgFee;
use Illuminate\Http\Request;

class PgFeeController extends Controller
{
    public function store(Request $request, PgEnrollment $enrollment)
    {
        $this->authorize('update', $enrollment->student);

        $request->validate([
            'fee_type' => 'required|string|max:50',
            'payment_date' => 'required|date',
            'receipt_number' => 'required|string|max:100',
        ]);

        PgFee::create([
            'pg_enrollment_id' => $enrollment->id,
            'fee_type' => $request->fee_type,
            'payment_date' => $request->payment_date,
            'receipt_number' => $request->receipt_number,
        ]);

        return back()->with('success', 'تم تسجيل إيصال الرسوم بنجاح.');
    }
}