<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Enums\Gender;
use Modules\Users\Enums\StudentStatus;
use Modules\Users\Enums\ParentRelationship;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'student_code',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'address',
        'city',
        'state',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'profile_photo',
        'medical_notes',
        'enrollment_date',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'enrollment_date' => 'date',
            'gender' => Gender::class,
            'status' => StudentStatus::class,
        ];
    }

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parents associated with the student.
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(ParentModel::class, 'parent_student', 'student_id', 'parent_id')
            ->withPivot(['relationship', 'is_primary_contact', 'can_pickup'])
            ->withTimestamps();
    }

    /**
     * Get the student's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Scope a query to only include active students.
     */
    public function scopeActive($query)
    {
        return $query->where('status', StudentStatus::ACTIVE);
    }

    /**
     * Scope a query to only include graduated students.
     */
    public function scopeGraduated($query)
    {
        return $query->where('status', StudentStatus::GRADUATED);
    }
}
