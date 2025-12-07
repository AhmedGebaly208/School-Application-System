<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Models\Staff;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'classes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'grade_id',
        'academic_year_id',
        'name',
        'section',
        'room_number',
        'capacity',
        'homeroom_teacher_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
        ];
    }

    /**
     * Get the grade that owns the class.
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Get the academic year that owns the class.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the homeroom teacher for the class.
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'homeroom_teacher_id');
    }

    /**
     * Get the subjects associated with the class.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_subject')
            ->withPivot(['teacher_id', 'academic_year_id', 'term_id', 'room'])
            ->withTimestamps();
    }

    /**
     * Get the class's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->section ? "{$this->name} - {$this->section}" : $this->name;
    }
}
