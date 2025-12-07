<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Administration\Enums\LeaveType;
use Modules\Administration\Enums\LeaveStatus;
use Modules\Users\Models\Staff;
// use Modules\Administration\Database\Factories\StaffLeaveFactory;

class StaffLeave extends Model
{
    use HasFactory;

    protected $table = 'staff_leaves';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'staff_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'requested_date',
        'approved_by_staff_id',
        'approved_date',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'leave_type' => LeaveType::class,
            'start_date' => 'date',
            'end_date' => 'date',
            'total_days' => 'integer',
            'status' => LeaveStatus::class,
            'requested_date' => 'date',
            'approved_date' => 'date',
        ];
    }

    /**
     * Relationships
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function approvedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'approved_by_staff_id');
    }

    /**
     * Computed Attributes
     */
    public function getIsApprovedAttribute(): bool
    {
        return $this->status === LeaveStatus::APPROVED;
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === LeaveStatus::PENDING;
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === LeaveStatus::APPROVED &&
               now()->between($this->start_date, $this->end_date);
    }

    /**
     * Query Scopes
     */
    public function scopeByStaff($query, int $staffId)
    {
        return $query->where('staff_id', $staffId);
    }

    public function scopePending($query)
    {
        return $query->where('status', LeaveStatus::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', LeaveStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', LeaveStatus::REJECTED);
    }

    public function scopeByType($query, LeaveType $leaveType)
    {
        return $query->where('leave_type', $leaveType);
    }

    public function scopeActive($query)
    {
        return $query->where('status', LeaveStatus::APPROVED)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', LeaveStatus::APPROVED)
            ->whereDate('start_date', '>', now());
    }

    // protected static function newFactory(): StaffLeaveFactory
    // {
    //     // return StaffLeaveFactory::new();
    // }
}
