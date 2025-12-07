<?php

namespace Modules\Counseling\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Counseling\Enums\CaseType;
use Modules\Counseling\Enums\CasePriority;
use Modules\Counseling\Enums\CaseStatus;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
// use Modules\Counseling\Database\Factories\CounselingCaseFactory;

class CounselingCase extends Model
{
    use HasFactory;

    protected $table = 'cases';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'assigned_to_staff_id',
        'case_type',
        'priority',
        'title',
        'description',
        'opened_date',
        'closed_date',
        'status',
        'is_confidential',
    ];

    protected function casts(): array
    {
        return [
            'case_type' => CaseType::class,
            'priority' => CasePriority::class,
            'opened_date' => 'date',
            'closed_date' => 'date',
            'status' => CaseStatus::class,
            'is_confidential' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function assignedToStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_to_staff_id');
    }

    public function caseNotes(): HasMany
    {
        return $this->hasMany(CaseNote::class, 'case_id');
    }

    public function counselingSessions(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'case_id');
    }

    /**
     * Computed Attributes
     */
    public function getIsOpenAttribute(): bool
    {
        return $this->status === CaseStatus::OPEN;
    }

    public function getDurationDaysAttribute(): ?int
    {
        if ($this->closed_date) {
            return $this->opened_date->diffInDays($this->closed_date);
        }

        return $this->opened_date->diffInDays(now());
    }

    /**
     * Query Scopes
     */
    public function scopeOpen($query)
    {
        return $query->where('status', CaseStatus::OPEN);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', CaseStatus::CLOSED);
    }

    public function scopeByPriority($query, CasePriority $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeAssignedTo($query, int $staffId)
    {
        return $query->where('assigned_to_staff_id', $staffId);
    }

    // protected static function newFactory(): CounselingCaseFactory
    // {
    //     // return CounselingCaseFactory::new();
    // }
}
