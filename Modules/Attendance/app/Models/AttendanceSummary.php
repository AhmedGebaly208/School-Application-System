<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Academics\Models\AcademicYear;
use Modules\Academics\Models\Term;

class AttendanceSummary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'attendance_summary';

    /**
     * Indicates if the model should use created_at timestamp.
     */
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'term_id',
        'total_days',
        'present_days',
        'absent_days',
        'late_days',
        'excused_days',
        'attendance_rate',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'total_days' => 'integer',
            'present_days' => 'integer',
            'absent_days' => 'integer',
            'late_days' => 'integer',
            'excused_days' => 'integer',
            'attendance_rate' => 'decimal:2',
        ];
    }

    /**
     * Get the student that owns the attendance summary.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic year for the attendance summary.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the term for the attendance summary.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the attendance rate as a percentage.
     */
    public function getAttendanceRatePercentageAttribute(): string
    {
        return number_format($this->attendance_rate, 2) . '%';
    }
}
