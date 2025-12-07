<?php

namespace Modules\Communication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Models\Staff;
use Modules\Communication\Enums\AnnouncementType;
use Modules\Communication\Enums\AnnouncementPriority;
use Modules\Communication\Enums\AnnouncementTargetAudience;
use Modules\Communication\Enums\AnnouncementStatus;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'announcement_type',
        'priority',
        'target_audience',
        'published_by_staff_id',
        'published_at',
        'expires_at',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'announcement_type' => AnnouncementType::class,
            'priority' => AnnouncementPriority::class,
            'target_audience' => AnnouncementTargetAudience::class,
            'status' => AnnouncementStatus::class,
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Get the staff member who published this announcement.
     */
    public function publishedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'published_by_staff_id');
    }

    /**
     * Get the announcement targets.
     */
    public function targets(): HasMany
    {
        return $this->hasMany(AnnouncementTarget::class);
    }

    /**
     * Check if the announcement is published.
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === AnnouncementStatus::PUBLISHED && !is_null($this->published_at);
    }

    /**
     * Check if the announcement is expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return !is_null($this->expires_at) && $this->expires_at < Carbon::now();
    }

    /**
     * Check if the announcement is active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->is_published && !$this->is_expired;
    }

    /**
     * Scope a query to only include published announcements.
     */
    public function scopePublished($query)
    {
        return $query->where('status', AnnouncementStatus::PUBLISHED)
            ->whereNotNull('published_at');
    }

    /**
     * Scope a query to only include active announcements.
     */
    public function scopeActive($query)
    {
        return $query->published()
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', Carbon::now());
            });
    }

    /**
     * Scope a query to only include expired announcements.
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<', Carbon::now());
    }
}
