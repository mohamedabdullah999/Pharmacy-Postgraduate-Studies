<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pg_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_enrollment_id')->constrained('pg_enrollments')->cascadeOnDelete();
            
            $table->string('fee_type')->index(); 
            
            $table->date('payment_date')->nullable();
            $table->string('receipt_number')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_fees');
    }
};
