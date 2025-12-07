<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Library\Enums\BorrowingStatus;
use Modules\Library\Enums\BookCondition;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('borrowed_date');
            $table->date('due_date');
            $table->date('returned_date')->nullable();
            $table->foreignId('issued_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('received_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->decimal('fine_amount', 8, 2)->default(0.00);
            $table->boolean('fine_paid')->default(false);
            $table->enum('condition_on_return', BookCondition::values())->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', BorrowingStatus::values())->default(BorrowingStatus::ACTIVE->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['book_id', 'status']);
            $table->index(['student_id', 'status']);
            $table->index('status');
            $table->index(['borrowed_date', 'due_date']);
            $table->index('issued_by_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_borrowings');
    }
};
