<?php

namespace Modules\Timetable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Modules\Timetable\Database\Factories\TimeSlotFactory;

class TimeSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'duration_minutes',
        'slot_order',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'duration_minutes' => 'integer',
            'slot_order' => 'integer',
        ];
    }

    /**
     * Relationships
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Computed Attributes
     */
    public function getTimeRangeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    /**
     * Query Scopes
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('slot_order');
    }

    public function scopeByOrder($query, int $order)
    {
        return $query->where('slot_order', $order);
    }

    // protected static function newFactory(): TimeSlotFactory
    // {
    //     // return TimeSlotFactory::new();
    // }
}
