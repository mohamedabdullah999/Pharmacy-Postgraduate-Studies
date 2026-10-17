<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentProgram extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function extensions()
    {
        return $this->hasMany(ProgramExtension::class);
    }

    public function suspensions()
    {
        return $this->hasMany(ProgramSuspension::class);
    }

    public function feePayments()
    {
        return $this->hasMany(ProgramFeePayment::class);
    }
}