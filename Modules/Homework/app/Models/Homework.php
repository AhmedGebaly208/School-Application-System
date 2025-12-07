<?php

namespace Modules\Homework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Academics\Models\ClassSubject;
use Modules\Users\Models\Staff;
use Modules\Homework\Enums\SubmissionType;
use Modules\Homework\Enums\HomeworkStatus;
use Carbon\Carbon;

class Homework extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'homework';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_subject_id',
        'teacher_id',
        'title',
        'description',
        'assigned_date',
        'due_date',
        'total_marks',
        'submission_type',
        'max_file_size_mb',
        'allowed_file_types',
        'instructions',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'assigned_date' => 'date',
            'due_date' => 'date',
            'total_marks' => 'integer',
            'max_file_size_mb' => 'integer',
            'allowed_file_types' => 'array',
            'submission_type' => SubmissionType::class,
            'status' => HomeworkStatus::class,
        ];
    }

    /**
     * Get the class subject for this homework.
     */
    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Get the teacher who assigned this homework.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    /**
     * Get the homework attachments.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(HomeworkAttachment::class);
    }

    /**
     * Get the homework submissions.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    /**
     * Check if the homework is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date < Carbon::today();
    }

    /**
     * Get the number of days until due date.
     */
    public function getDaysUntilDueAttribute(): int
    {
        return Carbon::today()->diffInDays($this->due_date, false);
    }

    /**
     * Scope a query to only include active homework.
     */
    public function scopeActive($query)
    {
        return $query->where('status', HomeworkStatus::ACTIVE);
    }

    /**
     * Scope a query to only include upcoming homework.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('due_date', '>=', Carbon::today())
            ->where('status', HomeworkStatus::ACTIVE);
    }

    /**
     * Scope a query to only include overdue homework.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::today())
            ->where('status', HomeworkStatus::ACTIVE);
    }
}
