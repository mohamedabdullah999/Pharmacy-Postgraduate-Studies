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
        Schema::create('pg_extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_enrollment_id')->constrained('pg_enrollments')->cascadeOnDelete();
            
            $table->tinyInteger('extension_number'); 
            $table->string('reason')->nullable(); 
            $table->date('dept_approval_date')->nullable();
            $table->date('studies_approval_date')->nullable();
            $table->date('faculty_approval_date')->nullable(); 
            $table->date('univ_approval_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_extensions');
    }
};
