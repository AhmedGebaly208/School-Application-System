<?php

namespace Modules\Timetable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Timetable\Enums\DayOfWeek;
use Modules\Academics\Models\ClassSubject;
use Modules\Academics\Models\AcademicYear;
use Modules\Academics\Models\Term;
// use Modules\Timetable\Database\Factories\ScheduleFactory;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_subject_id',
        'day_of_week',
        'time_slot_id',
        'room_id',
        'academic_year_id',
        'term_id',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => DayOfWeek::class,
        ];
    }

    /**
     * Relationships
     */
    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class);
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Query Scopes
     */
    public function scopeByClass($query, int $classId)
    {
        return $query->whereHas('classSubject', function ($q) use ($classId) {
            $q->where('class_id', $classId);
        });
    }

    public function scopeByTeacher($query, int $teacherId)
    {
        return $query->whereHas('classSubject', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        });
    }

    public function scopeByDay($query, DayOfWeek $day)
    {
        return $query->where('day_of_week', $day);
    }

    public function scopeByRoom($query, int $roomId)
    {
        return $query->where('room_id', $roomId);
    }

    public function scopeByAcademicYear($query, int $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    public function scopeByTerm($query, int $termId)
    {
        return $query->where('term_id', $termId);
    }

    public function scopeForDayAndTime($query, DayOfWeek $day, int $timeSlotId)
    {
        return $query->where('day_of_week', $day)
            ->where('time_slot_id', $timeSlotId);
    }

    /**
     * Business Logic Methods
     */
    public function hasRoomConflict(): bool
    {
        if (!$this->room_id) {
            return false;
        }

        return static::where('room_id', $this->room_id)
            ->where('day_of_week', $this->day_of_week)
            ->where('time_slot_id', $this->time_slot_id)
            ->where('academic_year_id', $this->academic_year_id)
            ->where('term_id', $this->term_id)
            ->where('id', '!=', $this->id)
            ->exists();
    }

    // protected static function newFactory(): ScheduleFactory
    // {
    //     // return ScheduleFactory::new();
    // }
}
