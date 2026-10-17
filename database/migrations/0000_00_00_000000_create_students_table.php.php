<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('national_id')->unique(); 
            $table->string('student_code')->unique()->nullable();
            $table->string('legacy_serial_number')->nullable(); 
            
            $table->string('full_name'); 
            $table->date('birth_date')->nullable(); 
            $table->string('birth_governorate')->nullable(); 
            $table->string('current_address')->nullable();
            $table->string('mobile')->nullable(); 
            $table->string('email')->nullable();
            $table->string('current_job')->nullable();
            
            $table->string('previous_qualification')->nullable(); 
            $table->string('qualification_year')->nullable(); 
            $table->string('qualification_institution')->nullable(); 
            $table->string('overall_grade')->nullable(); 
            $table->string('specialization_grade')->nullable(); 
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
