<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Counseling\Enums\SessionType;
use Modules\Counseling\Enums\SessionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->nullable()->constrained('cases')->onDelete('set null');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('counselor_id')->constrained('staff')->onDelete('cascade');
            $table->date('session_date');
            $table->time('session_time');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->enum('session_type', SessionType::values());
            $table->string('location')->nullable();
            $table->text('topics_discussed')->nullable();
            $table->text('notes')->nullable();
            $table->text('recommendations')->nullable();
            $table->date('next_session_date')->nullable();
            $table->enum('status', SessionStatus::values())->default(SessionStatus::SCHEDULED->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['student_id', 'status']);
            $table->index(['counselor_id', 'session_date']);
            $table->index('case_id');
            $table->index(['session_date', 'session_time']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_sessions');
    }
};
