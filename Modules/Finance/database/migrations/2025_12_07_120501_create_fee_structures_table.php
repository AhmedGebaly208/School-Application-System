<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Enums\PaymentFrequency;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('fee_type_id')->constrained('fee_types')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('payment_frequency', PaymentFrequency::values());
            $table->unsignedTinyInteger('due_day_of_month')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['grade_id', 'academic_year_id']);
            $table->index('fee_type_id');
            $table->index('academic_year_id');

            // Unique constraint: one fee structure per grade per fee type per academic year
            $table->unique(['grade_id', 'fee_type_id', 'academic_year_id'], 'unique_fee_structure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
