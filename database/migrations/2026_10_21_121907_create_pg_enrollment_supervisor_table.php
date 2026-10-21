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
        Schema::create('pg_enrollment_supervisor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_enrollment_id')->constrained('pg_enrollments')->cascadeOnDelete();
            $table->foreignId('pg_supervisor_id')->constrained('pg_supervisors')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_enrollment_supervisor');
    }
};
