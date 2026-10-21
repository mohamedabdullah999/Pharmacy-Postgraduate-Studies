<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgExtension extends Model
{
    use HasFactory;

    protected $table = 'pg_extensions';

    protected $fillable = [
        'pg_enrollment_id', 'extension_number', 'reason',
        'dept_approval_date', 'studies_approval_date',
        'faculty_approval_date', 'univ_approval_date'
    ];

    public function enrollment()
    {
        return $this->belongsTo(PgEnrollment::class, 'pg_enrollment_id');
    }
}