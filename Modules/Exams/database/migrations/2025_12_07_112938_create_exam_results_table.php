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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('marks_obtained', 6, 2);
            $table->string('grade_letter', 5)->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('entered_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->timestamp('entered_at')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['exam_id', 'student_id']);
            $table->index('student_id');

            // Unique constraint: one result per student per exam
            $table->unique(['exam_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
