<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('program_type', ['pre_master', 'master', 'doctorate']); 

            $table->date('department_enrollment_approval_date')->nullable();
            $table->date('postgraduate_enrollment_approval_date')->nullable();
            $table->date('faculty_enrollment_approval_date')->nullable();
            $table->date('university_enrollment_approval_date')->nullable();

            $table->date('preparatory_courses_completion_date')->nullable(); 

            $table->date('department_registration_approval_date')->nullable();
            $table->date('postgraduate_registration_approval_date')->nullable();
            $table->date('faculty_registration_approval_date')->nullable();
            $table->date('university_registration_approval_date')->nullable();

            $table->text('thesis_title_ar')->nullable(); 
            $table->text('thesis_title_en')->nullable();
            $table->text('supervisory_committee_members_text')->nullable(); 

            $table->text('examining_committee_text')->nullable(); 
            $table->date('examining_dept_approval_date')->nullable();
            $table->date('examining_postgrad_approval_date')->nullable();
            $table->date('examining_faculty_approval_date')->nullable();
            $table->date('examining_university_approval_date')->nullable();

            $table->date('grant_dept_approval_date')->nullable();
            $table->date('grant_postgrad_approval_date')->nullable();
            $table->date('grant_faculty_approval_date')->nullable();
            $table->date('grant_university_approval_date')->nullable();

            $table->date('registration_start_date')->nullable();
            $table->integer('registration_duration_days')->default(365);
            $table->integer('extension_days')->default(0);
            $table->string('academic_status')->default('active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_programs');
    }
};