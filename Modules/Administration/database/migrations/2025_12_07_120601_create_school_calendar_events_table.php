<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Administration\Enums\EventType;
use Modules\Administration\Enums\EventStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('event_type', EventType::values());
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('organizer_staff_id')->constrained('staff')->onDelete('cascade');
            $table->json('target_grades')->nullable(); // array of grade_ids
            $table->json('target_classes')->nullable(); // array of class_ids
            $table->enum('status', EventStatus::values())->default(EventStatus::SCHEDULED->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['academic_year_id', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index('event_type');
            $table->index('status');
            $table->index('organizer_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_calendar_events');
    }
};
