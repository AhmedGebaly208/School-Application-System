<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Timetable\Enums\DayOfWeek;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Note: Requires class_subject table from Academics module
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subject')->onDelete('cascade');
            $table->enum('day_of_week', DayOfWeek::values());
            $table->foreignId('time_slot_id')->constrained('time_slots')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('term_id')->nullable()->constrained('terms')->onDelete('cascade');
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['class_subject_id', 'day_of_week']);
            $table->index(['academic_year_id', 'term_id']);
            $table->index(['day_of_week', 'time_slot_id']);
            $table->index('room_id');

            // Unique constraint: prevent double booking of room at same time
            $table->unique(['room_id', 'day_of_week', 'time_slot_id', 'academic_year_id', 'term_id'], 'unique_room_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
