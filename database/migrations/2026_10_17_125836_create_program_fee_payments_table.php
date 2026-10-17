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
        Schema::create('program_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_program_id')->constrained('student_programs')->cascadeOnDelete();
            
            $table->enum('fee_type', ['tuition', 'extension', 'suspension']);
            $table->tinyInteger('period_number'); 
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('receipt_number')->nullable();
            
            $table->timestamps();
            
            $table->index(['student_program_id', 'fee_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_fee_payments');
    }
};
