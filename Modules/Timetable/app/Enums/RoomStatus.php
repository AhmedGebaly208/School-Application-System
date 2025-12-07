<?php

namespace Modules\Timetable\Enums;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case MAINTENANCE = 'maintenance';
    case RESERVED = 'reserved';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::AVAILABLE->value => 'Available',
            self::MAINTENANCE->value => 'Under Maintenance',
            self::RESERVED->value => 'Reserved',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::AVAILABLE => 'success',
            self::MAINTENANCE => 'warning',
            self::RESERVED => 'info',
        };
    }
}
