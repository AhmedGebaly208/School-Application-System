<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Academics\Models\Term;

class ReportCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'term_id',
        'total_marks',
        'obtained_marks',
        'percentage',
        'gpa',
        'overall_grade',
        'rank_in_class',
        'attendance_rate',
        'teacher_remarks',
        'principal_remarks',
        'issued_date',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'total_marks' => 'decimal:2',
            'obtained_marks' => 'decimal:2',
            'percentage' => 'decimal:2',
            'gpa' => 'decimal:2',
            'attendance_rate' => 'decimal:2',
            'rank_in_class' => 'integer',
            'issued_date' => 'date',
        ];
    }

    /**
     * Get the student for this report card.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the term for this report card.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the formatted percentage.
     */
    public function getFormattedPercentageAttribute(): string
    {
        return number_format($this->percentage, 2) . '%';
    }

    /**
     * Get the formatted GPA.
     */
    public function getFormattedGpaAttribute(): string
    {
        return number_format($this->gpa, 2);
    }

    /**
     * Check if the report card has been issued.
     */
    public function getIsIssuedAttribute(): bool
    {
        return !is_null($this->issued_date);
    }
}
