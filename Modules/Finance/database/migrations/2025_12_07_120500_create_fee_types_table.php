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
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Tuition", "Transportation", "Books"
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();

            // Indexes for query optimization
            $table->index('code');
            $table->index('is_mandatory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};
