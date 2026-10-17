<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\StudentProgram;

class RegistrationExpiryService
{
    protected int $warningThresholdDays = 30;

    public function calculateExpiry(StudentProgram $program): array
    {
        if (!$program->registration_start_date || $program->registration_duration_days === null) {
            return [
                'status' => 'بيانات القيد غير مكتملة',
                'end_date' => null,
                'remaining_days' => null,
            ];
        }

        $startDate = Carbon::parse($program->registration_start_date);
        
        $totalDays = $program->registration_duration_days + ($program->extension_days ?? 0);
        
        $endDate = $startDate->copy()->addDays($totalDays);
        $today = Carbon::today();
        
        $remainingDays = $today->diffInDays($endDate, false);

        if ($remainingDays < 0) {
            $status = 'انتهى القيد';
        } elseif ($remainingDays <= $this->warningThresholdDays) {
            $status = 'القيد اقترب من الانتهاء';
        } else {
            $status = 'ساري القيد';
        }

        return [
            'status' => $status,
            'end_date' => $endDate->format('Y-m-d'),
            'remaining_days' => $remainingDays > 0 ? (int) $remainingDays : 0,
        ];
    }
}