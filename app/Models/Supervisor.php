<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $guarded = ['id'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'supervisor_student')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }
}