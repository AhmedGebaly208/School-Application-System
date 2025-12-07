<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Enums\InvoiceStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('term_id')->nullable()->constrained('terms')->onDelete('set null');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('net_amount', 10, 2);
            $table->enum('status', InvoiceStatus::values())->default(InvoiceStatus::DRAFT->value);
            $table->text('notes')->nullable();
            $table->foreignId('issued_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();

            // Indexes for query optimization
            $table->index('invoice_number');
            $table->index(['student_id', 'status']);
            $table->index(['academic_year_id', 'term_id']);
            $table->index('status');
            $table->index(['invoice_date', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
