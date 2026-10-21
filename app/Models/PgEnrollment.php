<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PgEnrollment extends Model
{
    use HasFactory;

    protected $table = 'pg_enrollments';

    protected $fillable = [
        'pg_student_id', 'program_type', 'enrollment_start_date', 'enrollment_duration_days',
        'activation_token', 'enroll_dept_approval_date', 'enroll_studies_approval_date',
        'enroll_faculty_approval_date', 'enroll_univ_approval_date', 'preliminary_courses_end_date',
        'reg_dept_approval_date', 'reg_studies_approval_date', 'reg_faculty_approval_date',
        'reg_univ_approval_date', 'thesis_title_ar', 'thesis_title_en', 'discussion_committee',
        'form_dept_approval_date', 'form_studies_approval_date', 'form_faculty_approval_date',
        'form_univ_approval_date', 'grant_dept_approval_date', 'grant_studies_approval_date',
        'grant_faculty_approval_date', 'grant_univ_approval_date'
    ];

    protected $casts = [
        'enrollment_start_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(PgStudent::class, 'pg_student_id');
    }

    public function supervisors()
    {
        return $this->belongsToMany(PgSupervisor::class, 'pg_enrollment_supervisor', 'pg_enrollment_id', 'pg_supervisor_id')->withTimestamps();
    }

    public function extensions()
    {
        return $this->hasMany(PgExtension::class, 'pg_enrollment_id');
    }

    public function suspensions()
    {
        return $this->hasMany(PgSuspension::class, 'pg_enrollment_id');
    }

    public function fees()
    {
        return $this->hasMany(PgFee::class, 'pg_enrollment_id');
    }

    
  
    public function getEnrollmentEndDateAttribute()
    {
        if (!$this->enrollment_start_date) {
            return null;
        }

        $endDate = Carbon::parse($this->enrollment_start_date)->addDays($this->enrollment_duration_days);
        

        return $endDate->toDateString();
    }


    public function getEnrollmentStatusAttribute()
    {
        $endDate = $this->enrollment_end_date;

        if (!$endDate) {
            return 'غير محدد';
        }

        if (now()->startOfDay()->lte(Carbon::parse($endDate)->startOfDay())) {
            return 'ساري';
        }

        return 'منتهي';
    }
}