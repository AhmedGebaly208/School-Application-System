<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submission_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_submission_id')->constrained('homework_submissions')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedInteger('file_size'); // in bytes
            $table->string('mime_type');
            $table->timestamps();

            // Indexes for query optimization
            $table->index('homework_submission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_attachments');
    }
};
