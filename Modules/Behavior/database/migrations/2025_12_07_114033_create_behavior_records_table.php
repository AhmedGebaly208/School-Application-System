<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Behavior\Enums\BehaviorRecordStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('behavior_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('behavior_category_id')->constrained('behavior_categories')->onDelete('cascade');
            $table->foreignId('reported_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->string('location')->nullable();
            $table->text('description');
            $table->text('action_taken')->nullable();
            $table->integer('points_awarded')->default(0);
            $table->boolean('follow_up_required')->default(false);
            $table->foreignId('followed_up_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->text('follow_up_notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->boolean('parent_notified')->default(false);
            $table->timestamp('parent_notified_at')->nullable();
            $table->enum('status', BehaviorRecordStatus::values())->default(BehaviorRecordStatus::REPORTED->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['student_id', 'incident_date']);
            $table->index(['behavior_category_id', 'incident_date']);
            $table->index('incident_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_records');
    }
};
