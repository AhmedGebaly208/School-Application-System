<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Administration\Enums\DocumentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('documentable_type');
            $table->unsignedBigInteger('documentable_id');
            $table->enum('document_type', DocumentType::values());
            $table->string('title');
            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedInteger('file_size'); // in bytes
            $table->string('mime_type');
            $table->foreignId('issued_by_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->date('issued_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['documentable_type', 'documentable_id']);
            $table->index('document_type');
            $table->index('issued_by_staff_id');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
