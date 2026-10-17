<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function programs()
    {
        return $this->hasMany(StudentProgram::class);
    }
}