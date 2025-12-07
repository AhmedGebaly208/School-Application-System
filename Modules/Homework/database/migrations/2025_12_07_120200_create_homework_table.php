<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Homework\Enums\SubmissionType;
use Modules\Homework\Enums\HomeworkStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Note: Requires class_subject table from Academics module
     */
    public function up(): void
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subject')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('staff')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->date('assigned_date');
            $table->date('due_date');
            $table->unsignedSmallInteger('total_marks');
            $table->enum('submission_type', SubmissionType::values())->default(SubmissionType::FILE->value);
            $table->unsignedTinyInteger('max_file_size_mb')->nullable();
            $table->json('allowed_file_types')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', HomeworkStatus::values())->default(HomeworkStatus::ACTIVE->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['class_subject_id', 'status']);
            $table->index('teacher_id');
            $table->index(['assigned_date', 'due_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
