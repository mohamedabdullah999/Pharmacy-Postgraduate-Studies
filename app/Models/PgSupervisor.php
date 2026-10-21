<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PgSupervisor extends Model
{
    use HasFactory;

    protected $table = 'pg_supervisors';

    protected $fillable = [
        'user_id', 'name', 'national_id', 'activation_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->belongsToMany(PgEnrollment::class, 'pg_enrollment_supervisor', 'pg_supervisor_id', 'pg_enrollment_id')->withTimestamps();
    }
}