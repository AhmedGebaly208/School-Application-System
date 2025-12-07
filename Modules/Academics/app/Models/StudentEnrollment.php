<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Academics\Enums\StudentEnrollmentStatus;

class StudentEnrollment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'student_enrollment';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year_id',
        'enrollment_date',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'enrollment_date' => 'date',
            'status' => StudentEnrollmentStatus::class,
        ];
    }

    /**
     * Get the student that owns the enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class that owns the enrollment.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the academic year for the enrollment.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', StudentEnrollmentStatus::Active);
    }
}
