<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PgStudent extends Model
{
    use HasFactory;

    protected $table = 'pg_students';

    protected $fillable = [
        'user_id', 'name', 'national_id', 'student_code', 'dob',
        'birth_governorate', 'current_address', 'mobile_number',
        'email', 'current_job', 'academic_degree', 'degree_year',
        'degree_institution', 'general_grade', 'specialization_grade'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(PgEnrollment::class, 'pg_student_id');
    }
}