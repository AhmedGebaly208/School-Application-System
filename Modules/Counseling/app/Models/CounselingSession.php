<?php

namespace Modules\Counseling\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Counseling\Enums\SessionType;
use Modules\Counseling\Enums\SessionStatus;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
// use Modules\Counseling\Database\Factories\CounselingSessionFactory;

class CounselingSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'case_id',
        'student_id',
        'counselor_id',
        'session_date',
        'session_time',
        'duration_minutes',
        'session_type',
        'location',
        'topics_discussed',
        'notes',
        'recommendations',
        'next_session_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'session_time' => 'datetime:H:i',
            'duration_minutes' => 'integer',
            'session_type' => SessionType::class,
            'next_session_date' => 'date',
            'status' => SessionStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function counselingCase(): BelongsTo
    {
        return $this->belongsTo(CounselingCase::class, 'case_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'counselor_id');
    }

    /**
     * Computed Attributes
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === SessionStatus::COMPLETED;
    }

    public function getHasNextSessionAttribute(): bool
    {
        return $this->next_session_date !== null;
    }

    /**
     * Query Scopes
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', SessionStatus::SCHEDULED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', SessionStatus::COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', SessionStatus::CANCELLED);
    }

    public function scopeByStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByCounselor($query, int $counselorId)
    {
        return $query->where('counselor_id', $counselorId);
    }

    public function scopeByCase($query, int $caseId)
    {
        return $query->where('case_id', $caseId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', SessionStatus::SCHEDULED)
            ->where('session_date', '>=', now());
    }

    // protected static function newFactory(): CounselingSessionFactory
    // {
    //     // return CounselingSessionFactory::new();
    // }
}
