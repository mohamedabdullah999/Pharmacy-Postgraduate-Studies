<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgSuspension extends Model
{
    use HasFactory;

    protected $table = 'pg_suspensions';

    protected $fillable = [
        'pg_enrollment_id', 'suspension_number', 'reason',
        'dept_approval_date', 'studies_approval_date',
        'faculty_approval_date', 'univ_approval_date'
    ];

    public function enrollment()
    {
        return $this->belongsTo(PgEnrollment::class, 'pg_enrollment_id');
    }
}