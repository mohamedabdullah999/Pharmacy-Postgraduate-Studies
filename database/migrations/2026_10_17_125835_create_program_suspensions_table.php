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
        Schema::create('program_suspensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_program_id')->constrained('student_programs')->cascadeOnDelete();
            
            $table->tinyInteger('suspension_number');
            $table->text('reason')->nullable();
            
            $table->date('department_council_approval_date')->nullable();
            $table->date('postgraduate_committee_approval_date')->nullable();
            $table->date('faculty_council_approval_date')->nullable();
            $table->date('university_council_approval_date')->nullable();
            
            $table->timestamps();
            
            $table->unique(['student_program_id', 'suspension_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_suspensions');
    }
};
