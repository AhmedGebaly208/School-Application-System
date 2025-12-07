<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Behavior\Enums\BehaviorType;
use Modules\Behavior\Enums\BehaviorSeverity;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('behavior_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', BehaviorType::values());
            $table->integer('points');
            $table->enum('severity', BehaviorSeverity::values());
            $table->text('description')->nullable();
            $table->timestamps();

            // Indexes for query optimization
            $table->index('type');
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_categories');
    }
};
