<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Administration\Enums\StaffAttendanceStatus;
use Modules\Users\Models\Staff;
// use Modules\Administration\Database\Factories\StaffAttendanceFactory;

class StaffAttendance extends Model
{
    use HasFactory;

    protected $table = 'staff_attendance';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'staff_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_time' => 'datetime:H:i',
            'check_out_time' => 'datetime:H:i',
            'status' => StaffAttendanceStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Computed Attributes
     */
    public function getHoursWorkedAttribute(): ?float
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return null;
        }

        return $this->check_in_time->diffInHours($this->check_out_time, true);
    }

    public function getIsCheckedInAttribute(): bool
    {
        return $this->check_in_time !== null && $this->check_out_time === null;
    }

    /**
     * Query Scopes
     */
    public function scopeByStaff($query, int $staffId)
    {
        return $query->where('staff_id', $staffId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopePresent($query)
    {
        return $query->where('status', StaffAttendanceStatus::PRESENT);
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', StaffAttendanceStatus::ABSENT);
    }

    public function scopeLate($query)
    {
        return $query->where('status', StaffAttendanceStatus::LATE);
    }

    public function scopeOnLeave($query)
    {
        return $query->where('status', StaffAttendanceStatus::ON_LEAVE);
    }

    // protected static function newFactory(): StaffAttendanceFactory
    // {
    //     // return StaffAttendanceFactory::new();
    // }
}
