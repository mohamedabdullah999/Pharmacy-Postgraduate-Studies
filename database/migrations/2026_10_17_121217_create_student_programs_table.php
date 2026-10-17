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
        Schema::create('student_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            
            // Program Type (Pre-Master, Master, Doctorate)
            $table->enum('program_type', ['pre_master', 'master', 'doctorate'])->index();
            $table->string('academic_status')->default('active')->index(); // ساري، موقوف، الخ
            
            // Section 7: Critical Registration Fields
            $table->date('registration_start_date')->nullable(); // تاريخ موافقة المجلس على القيد (Authoritative Date)
            $table->unsignedInteger('registration_duration_days')->nullable(); // مدة القيد بالأيام
            $table->unsignedInteger('extension_days')->default(0); // مد القيد
            
            // Enrollment Approvals (Section 6.2)
            $table->date('department_enrollment_approval_date')->nullable();
            $table->date('postgraduate_committee_enrollment_approval_date')->nullable();
            $table->date('faculty_council_enrollment_approval_date')->nullable();
            $table->date('university_enrollment_approval_date')->nullable();
            $table->date('preparatory_courses_completion_date')->nullable();
            
            // Registration Approvals (Section 6.2 & 6.3)
            $table->date('department_registration_approval_date')->nullable();
            $table->date('postgraduate_committee_registration_approval_date')->nullable();
            $table->date('faculty_council_registration_approval_date')->nullable();
            $table->date('university_council_registration_approval_date')->nullable();
            
            // Thesis Information (Section 6.4)
            $table->string('thesis_title_ar')->nullable();
            $table->string('thesis_title_en')->nullable();
            $table->text('supervisory_committee_members_text')->nullable(); // Historical committee
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_programs');
    }
};
