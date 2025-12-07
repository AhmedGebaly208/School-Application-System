<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Counseling\Enums\NoteType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('case_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->date('note_date');
            $table->enum('note_type', NoteType::values());
            $table->text('content');
            $table->text('next_action')->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index(['case_id', 'note_date']);
            $table->index('staff_id');
            $table->index('note_type');
            $table->index('next_follow_up_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_notes');
    }
};
