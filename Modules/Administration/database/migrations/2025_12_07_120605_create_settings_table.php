<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Administration\Enums\SettingType;
use Modules\Administration\Enums\SettingGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->enum('type', SettingType::values())->default(SettingType::STRING->value);
            $table->enum('group', SettingGroup::values())->default(SettingGroup::GENERAL->value);
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            // Indexes for query optimization
            $table->index('key');
            $table->index('group');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
