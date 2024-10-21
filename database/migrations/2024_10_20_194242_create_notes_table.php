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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('note_type_id')->constrained('note_types');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('school_year_semester_id')->constrained('school_year_semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
