<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Enums\Gender;
use Modules\Users\Enums\StaffPosition;
use Modules\Users\Enums\ContractType;
use Modules\Users\Enums\StaffStatus;
use Carbon\Carbon;

class Staff extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'staff';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'national_id',
        'phone',
        'mobile',
        'address',
        'city',
        'state',
        'postal_code',
        'hire_date',
        'position',
        'department',
        'qualification',
        'specialization',
        'experience_years',
        'salary',
        'contract_type',
        'status',
        'profile_photo',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'hire_date' => 'date',
            'gender' => Gender::class,
            'position' => StaffPosition::class,
            'contract_type' => ContractType::class,
            'status' => StaffStatus::class,
            'salary' => 'decimal:2',
            'experience_years' => 'integer',
        ];
    }

    /**
     * Get the user that owns the staff profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the staff's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Get the staff's years of service.
     */
    public function getYearsOfServiceAttribute(): int
    {
        if (!$this->hire_date) {
            return 0;
        }

        return Carbon::parse($this->hire_date)->diffInYears(Carbon::now());
    }

    /**
     * Scope a query to only include active staff.
     */
    public function scopeActive($query)
    {
        return $query->where('status', StaffStatus::ACTIVE);
    }

    /**
     * Scope a query to only include teachers.
     */
    public function scopeTeachers($query)
    {
        return $query->where('position', StaffPosition::TEACHER);
    }
}
