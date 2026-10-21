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
        Schema::create('pg_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_student_id')->constrained('pg_students')->cascadeOnDelete();
            
            $table->enum('program_type', ['pre_master', 'master', 'phd'])->index();
            
            $table->date('enrollment_start_date')->nullable();
            $table->integer('enrollment_duration_days')->default(0);
            
            $table->string('activation_token')->nullable()->index();

            $table->date('enroll_dept_approval_date')->nullable();
            $table->date('enroll_studies_approval_date')->nullable();
            $table->date('enroll_faculty_approval_date')->nullable();
            $table->date('enroll_univ_approval_date')->nullable();
            $table->date('preliminary_courses_end_date')->nullable();

            $table->date('reg_dept_approval_date')->nullable();
            $table->date('reg_studies_approval_date')->nullable();
            $table->date('reg_faculty_approval_date')->nullable();
            $table->date('reg_univ_approval_date')->nullable();

            $table->text('thesis_title_ar')->nullable();
            $table->text('thesis_title_en')->nullable();

            $table->text('discussion_committee')->nullable();
            $table->date('form_dept_approval_date')->nullable();
            $table->date('form_studies_approval_date')->nullable();
            $table->date('form_faculty_approval_date')->nullable();
            $table->date('form_univ_approval_date')->nullable();

            $table->date('grant_dept_approval_date')->nullable();
            $table->date('grant_studies_approval_date')->nullable();
            $table->date('grant_faculty_approval_date')->nullable();
            $table->date('grant_univ_approval_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_enrollments');
    }
};
