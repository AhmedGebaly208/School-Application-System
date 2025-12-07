<?php

namespace Modules\Timetable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Timetable\Enums\RoomType;
use Modules\Timetable\Enums\RoomStatus;
// use Modules\Timetable\Database\Factories\RoomFactory;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'room_type',
        'capacity',
        'floor',
        'building',
        'has_projector',
        'has_computers',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'room_type' => RoomType::class,
            'capacity' => 'integer',
            'has_projector' => 'boolean',
            'has_computers' => 'boolean',
            'status' => RoomStatus::class,
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
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === RoomStatus::AVAILABLE;
    }

    public function getFullLocationAttribute(): string
    {
        $parts = array_filter([$this->building, $this->floor, $this->name]);
        return implode(' - ', $parts);
    }

    /**
     * Query Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', RoomStatus::AVAILABLE);
    }

    public function scopeByType($query, RoomType $roomType)
    {
        return $query->where('room_type', $roomType);
    }

    public function scopeWithProjector($query)
    {
        return $query->where('has_projector', true);
    }

    public function scopeWithComputers($query)
    {
        return $query->where('has_computers', true);
    }

    public function scopeByBuilding($query, string $building)
    {
        return $query->where('building', $building);
    }

    public function scopeMinCapacity($query, int $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }

    // protected static function newFactory(): RoomFactory
    // {
    //     // return RoomFactory::new();
    // }
}
