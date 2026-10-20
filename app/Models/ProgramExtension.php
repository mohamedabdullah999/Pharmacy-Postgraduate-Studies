<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramExtension extends Model
{
    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(StudentProgram::class, 'student_program_id');
    }
}