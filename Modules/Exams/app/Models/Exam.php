<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Academics\Models\ClassSubject;
use Modules\Academics\Models\Term;
use Modules\Users\Models\Staff;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_subject_id',
        'exam_type_id',
        'term_id',
        'name',
        'description',
        'exam_date',
        'duration_minutes',
        'total_marks',
        'passing_marks',
        'created_by_staff_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'exam_date' => 'date',
            'duration_minutes' => 'integer',
            'total_marks' => 'decimal:2',
            'passing_marks' => 'decimal:2',
        ];
    }

    /**
     * Get the class subject for this exam.
     */
    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Get the exam type.
     */
    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }

    /**
     * Get the term for this exam.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the staff member who created this exam.
     */
    public function createdByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'created_by_staff_id');
    }

    /**
     * Get the exam results.
     */
    public function results(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Scope a query to only include upcoming exams.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('exam_date', '>=', Carbon::today());
    }

    /**
     * Scope a query to only include past exams.
     */
    public function scopePast($query)
    {
        return $query->where('exam_date', '<', Carbon::today());
    }

    /**
     * Check if the exam is upcoming.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->exam_date >= Carbon::today();
    }
}
