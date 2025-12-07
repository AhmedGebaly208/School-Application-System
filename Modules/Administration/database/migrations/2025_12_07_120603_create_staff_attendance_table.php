<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Administration\Enums\StaffAttendanceStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->date('date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('status', StaffAttendanceStatus::values())->default(StaffAttendanceStatus::PRESENT->value);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['staff_id', 'date']);
            $table->index('date');
            $table->index('status');

            // Unique constraint: one attendance record per staff per day
            $table->unique(['staff_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_attendance');
    }
};
