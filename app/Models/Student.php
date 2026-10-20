<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function programs()
    {
        return $this->hasMany(StudentProgram::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'supervisor_student')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }
}