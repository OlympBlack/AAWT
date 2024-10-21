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
        Schema::create('school_year_semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained('school_years');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_year_semesters');
    }
};
