<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
use Modules\Academics\Models\SchoolClass;
use Modules\Attendance\Enums\AttendanceStatus;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'status',
        'check_in_time',
        'check_out_time',
        'marked_by_staff_id',
        'notes',
        'parent_notified',
        'parent_notified_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_time' => 'datetime',
            'check_out_time' => 'datetime',
            'status' => AttendanceStatus::class,
            'parent_notified' => 'boolean',
            'parent_notified_at' => 'datetime',
        ];
    }

    /**
     * Get the student that owns the attendance.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class that owns the attendance.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the staff member who marked the attendance.
     */
    public function markedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'marked_by_staff_id');
    }

    /**
     * Get the status badge for UI display.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            AttendanceStatus::PRESENT->value => 'success',
            AttendanceStatus::ABSENT->value => 'danger',
            AttendanceStatus::LATE->value => 'warning',
            AttendanceStatus::EXCUSED->value => 'info',
            AttendanceStatus::EARLY_LEAVE->value => 'secondary',
        ];

        $color = $colors[$this->status->value] ?? 'secondary';
        return "<span class='badge badge-{$color}'>{$this->status->value}</span>";
    }

    /**
     * Scope a query to only include present records.
     */
    public function scopePresent($query)
    {
        return $query->where('status', AttendanceStatus::PRESENT);
    }

    /**
     * Scope a query to only include absent records.
     */
    public function scopeAbsent($query)
    {
        return $query->where('status', AttendanceStatus::ABSENT);
    }

    /**
     * Scope a query for a specific date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
