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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('payment_type_id')->constrained('payment_types');
            $table->foreignId('payment_mode_id')->constrained('payment_modes');
            $table->foreignId('classroom_id')->constrained('classrooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
