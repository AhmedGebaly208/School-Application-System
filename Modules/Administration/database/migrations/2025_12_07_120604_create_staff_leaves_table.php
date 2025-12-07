<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Administration\Enums\LeaveType;
use Modules\Administration\Enums\LeaveStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->enum('leave_type', LeaveType::values());
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('total_days');
            $table->text('reason');
            $table->enum('status', LeaveStatus::values())->default(LeaveStatus::PENDING->value);
            $table->date('requested_date');
            $table->foreignId('approved_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->date('approved_date')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['staff_id', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index('status');
            $table->index('leave_type');
            $table->index('approved_by_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_leaves');
    }
};
