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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('national_id')->unique(); // For assignment validation
            $table->timestamps();
        });
        
        // Now that supervisors exist, let's add the constraint to the users table
        Schema::table('users', function (Blueprint $table) {
             $table->foreign('supervisor_id')->references('id')->on('supervisors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropForeign(['supervisor_id']);
        });
        Schema::dropIfExists('supervisors');
    }
};
