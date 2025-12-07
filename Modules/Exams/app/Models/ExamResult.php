<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;

class ExamResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'exam_id',
        'student_id',
        'marks_obtained',
        'grade_letter',
        'remarks',
        'entered_by_staff_id',
        'entered_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'marks_obtained' => 'decimal:2',
            'entered_at' => 'datetime',
        ];
    }

    /**
     * Get the exam for this result.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the student for this result.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the staff member who entered this result.
     */
    public function enteredByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'entered_by_staff_id');
    }

    /**
     * Get the percentage score.
     */
    public function getPercentageAttribute(): float
    {
        if (!$this->exam || $this->exam->total_marks == 0) {
            return 0;
        }
        return ($this->marks_obtained / $this->exam->total_marks) * 100;
    }

    /**
     * Check if the student passed.
     */
    public function getIsPassedAttribute(): bool
    {
        return $this->marks_obtained >= $this->exam->passing_marks;
    }

    /**
     * Scope a query to only include passing results.
     */
    public function scopePassed($query)
    {
        return $query->whereHas('exam', function ($q) {
            $q->whereRaw('exam_results.marks_obtained >= exams.passing_marks');
        });
    }

    /**
     * Scope a query to only include failing results.
     */
    public function scopeFailed($query)
    {
        return $query->whereHas('exam', function ($q) {
            $q->whereRaw('exam_results.marks_obtained < exams.passing_marks');
        });
    }
}
