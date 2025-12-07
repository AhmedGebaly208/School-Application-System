<?php

namespace Modules\Communication\Enums;

enum MessagePriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public static function values(): array
    {
        return array_map(fn (self $priority) => $priority->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::LOW->value => 'Low',
            self::NORMAL->value => 'Normal',
            self::HIGH->value => 'High',
            self::URGENT->value => 'Urgent',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'gray',
            self::NORMAL => 'info',
            self::HIGH => 'warning',
            self::URGENT => 'danger',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::LOW => 'secondary',
            self::NORMAL => 'primary',
            self::HIGH => 'warning',
            self::URGENT => 'danger',
        };
    }
}
