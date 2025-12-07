<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Staff;

class ClassSubject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'class_subject';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'academic_year_id',
        'term_id',
        'room',
    ];

    /**
     * Get the class that owns the class subject.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the subject that owns the class subject.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher for the class subject.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    /**
     * Get the academic year for the class subject.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the term for the class subject.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
