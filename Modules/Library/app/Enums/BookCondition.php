<?php

namespace Modules\Library\Enums;

enum BookCondition: string
{
    case GOOD = 'good';
    case DAMAGED = 'damaged';
    case LOST = 'lost';

    public static function values(): array
    {
        return array_map(fn (self $condition) => $condition->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::GOOD->value => 'Good',
            self::DAMAGED->value => 'Damaged',
            self::LOST->value => 'Lost',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::GOOD => 'success',
            self::DAMAGED => 'warning',
            self::LOST => 'danger',
        };
    }
}
