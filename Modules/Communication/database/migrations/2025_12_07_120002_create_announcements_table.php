<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Communication\Enums\AnnouncementType;
use Modules\Communication\Enums\AnnouncementPriority;
use Modules\Communication\Enums\AnnouncementTargetAudience;
use Modules\Communication\Enums\AnnouncementStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('announcement_type', AnnouncementType::values());
            $table->enum('priority', AnnouncementPriority::values())->default(AnnouncementPriority::NORMAL->value);
            $table->enum('target_audience', AnnouncementTargetAudience::values())->default(AnnouncementTargetAudience::ALL->value);
            $table->foreignId('published_by_staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', AnnouncementStatus::values())->default(AnnouncementStatus::DRAFT->value);
            $table->timestamps();

            // Indexes for query optimization
            $table->index('status');
            $table->index('published_at');
            $table->index('expires_at');
            $table->index(['status', 'published_at']);
            $table->index('published_by_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
