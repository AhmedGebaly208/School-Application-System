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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subject')->onDelete('cascade');
            $table->foreignId('exam_type_id')->constrained('exam_types')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('exam_date');
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->decimal('total_marks', 6, 2);
            $table->decimal('passing_marks', 6, 2);
            $table->foreignId('created_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['class_subject_id', 'exam_date']);
            $table->index(['term_id', 'exam_date']);
            $table->index('exam_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
