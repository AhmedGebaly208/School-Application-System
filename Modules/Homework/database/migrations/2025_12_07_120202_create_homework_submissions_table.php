<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Homework\Enums\SubmissionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->constrained('homework')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->timestamp('submission_date')->nullable();
            $table->text('submission_text')->nullable();
            $table->decimal('marks_obtained', 6, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            $table->enum('status', SubmissionStatus::values())->default(SubmissionStatus::PENDING->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['homework_id', 'status']);
            $table->index('student_id');
            $table->index('status');

            // Unique constraint: one submission per student per homework
            $table->unique(['homework_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework_submissions');
    }
};
