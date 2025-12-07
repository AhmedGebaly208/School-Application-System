<?php

namespace Modules\Library\Enums;

enum BookStatus: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case DAMAGED = 'damaged';
    case LOST = 'lost';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::AVAILABLE->value => 'Available',
            self::UNAVAILABLE->value => 'Unavailable',
            self::DAMAGED->value => 'Damaged',
            self::LOST->value => 'Lost',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::AVAILABLE => 'success',
            self::UNAVAILABLE => 'warning',
            self::DAMAGED => 'danger',
            self::LOST => 'gray',
        };
    }
}
