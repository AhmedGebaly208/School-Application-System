<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Counseling\Enums\CaseType;
use Modules\Counseling\Enums\CasePriority;
use Modules\Counseling\Enums\CaseStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('assigned_to_staff_id')->constrained('staff')->onDelete('cascade');
            $table->enum('case_type', CaseType::values());
            $table->enum('priority', CasePriority::values())->default(CasePriority::MEDIUM->value);
            $table->string('title');
            $table->text('description');
            $table->date('opened_date');
            $table->date('closed_date')->nullable();
            $table->enum('status', CaseStatus::values())->default(CaseStatus::OPEN->value);
            $table->boolean('is_confidential')->default(false);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['student_id', 'status']);
            $table->index(['assigned_to_staff_id', 'status']);
            $table->index('status');
            $table->index('priority');
            $table->index('case_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
