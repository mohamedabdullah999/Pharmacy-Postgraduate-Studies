<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgFee extends Model
{
    use HasFactory;

    protected $table = 'pg_fees';

    protected $fillable = [
        'pg_enrollment_id', 'fee_type', 'payment_date', 'receipt_number'
    ];

    public function enrollment()
    {
        return $this->belongsTo(PgEnrollment::class, 'pg_enrollment_id');
    }
}