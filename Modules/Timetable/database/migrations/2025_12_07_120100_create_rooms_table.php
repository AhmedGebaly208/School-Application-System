<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Timetable\Enums\RoomType;
use Modules\Timetable\Enums\RoomStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('room_type', RoomType::values());
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->string('floor')->nullable();
            $table->string('building')->nullable();
            $table->boolean('has_projector')->default(false);
            $table->boolean('has_computers')->default(false);
            $table->enum('status', RoomStatus::values())->default(RoomStatus::AVAILABLE->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index('code');
            $table->index('room_type');
            $table->index('status');
            $table->index(['building', 'floor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
