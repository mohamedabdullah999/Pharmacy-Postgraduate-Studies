<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;
        
        $program = $student ? $student->programs()->with(['extensions', 'suspensions', 'feePayments'])->first() : null;

        $statusText = 'بيانات غير مكتملة';
        $statusColor = 'text-yellow-600';
        $endDate = null;

        if ($program && $program->registration_start_date && $program->registration_duration_days) {
            // حساب تاريخ الانتهاء: تاريخ البدء + مدة القيد بالأيام + أيام المد المضافة
            $startDate = Carbon::parse($program->registration_start_date);
            $totalDays = $program->registration_duration_days + $program->extension_days;
            $endDate = $startDate->copy()->addDays($totalDays);

            $now = Carbon::now();

            if ($now->greaterThan($endDate)) {
                $statusText = 'انتهى القيد';
                $statusColor = 'text-red-600 font-bold';
            } elseif ($now->diffInDays($endDate, false) <= 30) { // لو باقي 30 يوم أو أقل
                $statusText = 'القيد اقترب من الانتهاء';
                $statusColor = 'text-orange-600 font-bold';
            } else {
                $statusText = 'ساري القيد';
                $statusColor = 'text-green-700 font-bold';
            }
        }

        return view('student.dashboard', compact('student', 'program', 'statusText', 'statusColor', 'endDate'));
    }
}