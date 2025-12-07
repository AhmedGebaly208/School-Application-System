<?php

namespace Modules\Homework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
use Modules\Homework\Enums\SubmissionStatus;

class HomeworkSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'homework_id',
        'student_id',
        'submission_date',
        'submission_text',
        'marks_obtained',
        'feedback',
        'graded_by_staff_id',
        'graded_at',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'submission_date' => 'datetime',
            'marks_obtained' => 'decimal:2',
            'graded_at' => 'datetime',
            'status' => SubmissionStatus::class,
        ];
    }

    /**
     * Get the homework for this submission.
     */
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }

    /**
     * Get the student for this submission.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the staff member who graded this submission.
     */
    public function gradedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'graded_by_staff_id');
    }

    /**
     * Get the submission attachments.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(SubmissionAttachment::class);
    }

    /**
     * Check if submission is late.
     */
    public function getIsLateAttribute(): bool
    {
        if (!$this->submission_date || !$this->homework) {
            return false;
        }
        return $this->submission_date > $this->homework->due_date;
    }

    /**
     * Get the percentage score.
     */
    public function getPercentageAttribute(): ?float
    {
        if (!$this->marks_obtained || !$this->homework) {
            return null;
        }
        return ($this->marks_obtained / $this->homework->total_marks) * 100;
    }

    /**
     * Check if submission is graded.
     */
    public function getIsGradedAttribute(): bool
    {
        return $this->status === SubmissionStatus::GRADED;
    }

    /**
     * Scope a query to only include submitted homework.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', SubmissionStatus::SUBMITTED);
    }

    /**
     * Scope a query to only include graded homework.
     */
    public function scopeGraded($query)
    {
        return $query->where('status', SubmissionStatus::GRADED);
    }

    /**
     * Scope a query to only include late submissions.
     */
    public function scopeLate($query)
    {
        return $query->where('status', SubmissionStatus::LATE);
    }
}
