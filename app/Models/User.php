<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}