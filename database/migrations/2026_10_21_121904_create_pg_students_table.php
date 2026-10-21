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
        Schema::create('pg_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('name');
            $table->string('national_id', 14)->unique()->index();
            $table->string('student_code')->unique()->index();
            $table->date('dob')->nullable();
            $table->string('birth_governorate')->nullable();
            $table->text('current_address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('current_job')->nullable();
            $table->string('academic_degree')->nullable();
            $table->year('degree_year')->nullable();
            $table->string('degree_institution')->nullable();
            $table->string('general_grade')->nullable();
            $table->string('specialization_grade')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_students');
    }
};
