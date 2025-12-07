<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Enums\PaymentMethod;
use Modules\Finance\Enums\PaymentStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('payment_number')->unique();
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', PaymentMethod::values());
            $table->string('transaction_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->foreignId('received_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('status', PaymentStatus::values())->default(PaymentStatus::PENDING->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index('payment_number');
            $table->index(['invoice_id', 'status']);
            $table->index('payment_date');
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
