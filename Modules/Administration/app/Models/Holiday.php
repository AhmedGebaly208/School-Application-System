<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Administration\Enums\HolidayType;
use Modules\Academics\Models\AcademicYear;
// use Modules\Administration\Database\Factories\HolidayFactory;

class Holiday extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'academic_year_id',
        'name',
        'holiday_type',
        'start_date',
        'end_date',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'holiday_type' => HolidayType::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Relationships
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Computed Attributes
     */
    public function getDurationDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getIsActiveAttribute(): bool
    {
        return now()->between($this->start_date, $this->end_date);
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date->isFuture();
    }

    /**
     * Query Scopes
     */
    public function scopeByAcademicYear($query, int $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    public function scopeByType($query, HolidayType $holidayType)
    {
        return $query->where('holiday_type', $holidayType);
    }

    public function scopeActive($query)
    {
        return $query->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('start_date', '>', now());
    }

    // protected static function newFactory(): HolidayFactory
    // {
    //     // return HolidayFactory::new();
    // }
}
