<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Administration\Enums\EventType;
use Modules\Administration\Enums\EventStatus;
use Modules\Academics\Models\AcademicYear;
use Modules\Users\Models\Staff;
// use Modules\Administration\Database\Factories\SchoolCalendarEventFactory;

class SchoolCalendarEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'academic_year_id',
        'title',
        'description',
        'event_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'organizer_staff_id',
        'target_grades',
        'target_classes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_type' => EventType::class,
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'target_grades' => 'array',
            'target_classes' => 'array',
            'status' => EventStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function organizerStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'organizer_staff_id');
    }

    /**
     * Computed Attributes
     */
    public function getDurationDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getIsActiveAttribute(): bool
    {
        return now()->between($this->start_date, $this->end_date) &&
               $this->status === EventStatus::SCHEDULED;
    }

    /**
     * Query Scopes
     */
    public function scopeByAcademicYear($query, int $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', EventStatus::SCHEDULED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', EventStatus::COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', EventStatus::CANCELLED);
    }

    public function scopeByType($query, EventType $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', EventStatus::SCHEDULED)
            ->whereDate('start_date', '>=', now());
    }

    // protected static function newFactory(): SchoolCalendarEventFactory
    // {
    //     // return SchoolCalendarEventFactory::new();
    // }
}
