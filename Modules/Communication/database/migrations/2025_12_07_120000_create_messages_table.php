<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Communication\Enums\MessagePriority;
use Modules\Communication\Enums\SenderType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->enum('sender_type', SenderType::values());
            $table->string('subject');
            $table->text('body');
            $table->enum('priority', MessagePriority::values())->default(MessagePriority::NORMAL->value);
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->foreignId('parent_message_id')->nullable()->constrained('messages')->onDelete('cascade');
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['sender_type', 'sender_id']);
            $table->index('parent_message_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
