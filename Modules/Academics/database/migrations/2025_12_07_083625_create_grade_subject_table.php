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
        Schema::create('grade_subject', function (Blueprint $table) {
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->boolean('is_mandatory')->default(true);
            $table->unsignedTinyInteger('weekly_hours')->nullable();
            $table->timestamps();

            $table->primary(['grade_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_subject');
    }
};
