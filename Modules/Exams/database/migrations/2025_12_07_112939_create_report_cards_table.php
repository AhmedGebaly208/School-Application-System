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
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->decimal('total_marks', 8, 2);
            $table->decimal('obtained_marks', 8, 2);
            $table->decimal('percentage', 5, 2);
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('overall_grade', 5)->nullable();
            $table->unsignedSmallInteger('rank_in_class')->nullable();
            $table->decimal('attendance_rate', 5, 2)->nullable();
            $table->text('teacher_remarks')->nullable();
            $table->text('principal_remarks')->nullable();
            $table->date('issued_date')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['student_id', 'term_id']);
            $table->index('term_id');

            // Unique constraint: one report card per student per term
            $table->unique(['student_id', 'term_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_cards');
    }
};
