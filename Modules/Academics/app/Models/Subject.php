<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'credit_hours',
        'is_elective',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'credit_hours' => 'integer',
            'is_elective' => 'boolean',
        ];
    }

    /**
     * Get the grades associated with the subject.
     */
    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'grade_subject')
            ->withPivot(['is_mandatory', 'weekly_hours'])
            ->withTimestamps();
    }

    /**
     * Scope a query to only include mandatory subjects.
     */
    public function scopeMandatory($query)
    {
        return $query->where('is_elective', false);
    }

    /**
     * Scope a query to only include elective subjects.
     */
    public function scopeElective($query)
    {
        return $query->where('is_elective', true);
    }
}
