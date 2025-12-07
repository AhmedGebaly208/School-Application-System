<?php

namespace Modules\Behavior\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Behavior\Enums\BehaviorRecordStatus;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
// use Modules\Behavior\Database\Factories\BehaviorRecordFactory;

class BehaviorRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'behavior_category_id',
        'reported_by_staff_id',
        'incident_date',
        'incident_time',
        'location',
        'description',
        'action_taken',
        'points_awarded',
        'follow_up_required',
        'followed_up_by_staff_id',
        'follow_up_notes',
        'follow_up_date',
        'parent_notified',
        'parent_notified_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
            'incident_time' => 'datetime:H:i',
            'points_awarded' => 'integer',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'date',
            'parent_notified' => 'boolean',
            'parent_notified_at' => 'datetime',
            'status' => BehaviorRecordStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function behaviorCategory(): BelongsTo
    {
        return $this->belongsTo(BehaviorCategory::class);
    }

    public function reportedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'reported_by_staff_id');
    }

    public function followedUpByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'followed_up_by_staff_id');
    }

    /**
     * Computed Attributes
     */
    public function getRequiresFollowUpAttribute(): bool
    {
        return $this->follow_up_required && $this->status !== BehaviorRecordStatus::RESOLVED;
    }

    public function getIsPositiveAttribute(): bool
    {
        return $this->points_awarded > 0;
    }

    /**
     * Query Scopes
     */
    public function scopeByStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeReported($query)
    {
        return $query->where('status', BehaviorRecordStatus::REPORTED);
    }

    public function scopeResolved($query)
    {
        return $query->where('status', BehaviorRecordStatus::RESOLVED);
    }

    public function scopeRequiresFollowUp($query)
    {
        return $query->where('follow_up_required', true)
            ->where('status', '!=', BehaviorRecordStatus::RESOLVED);
    }

    public function scopeParentNotNotified($query)
    {
        return $query->where('parent_notified', false);
    }

    public function scopePositive($query)
    {
        return $query->where('points_awarded', '>', 0);
    }

    public function scopeNegative($query)
    {
        return $query->where('points_awarded', '<', 0);
    }

    // protected static function newFactory(): BehaviorRecordFactory
    // {
    //     // return BehaviorRecordFactory::new();
    // }
}
