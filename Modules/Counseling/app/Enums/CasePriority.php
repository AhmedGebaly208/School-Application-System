<?php

namespace Modules\Counseling\Enums;

enum CasePriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public static function values(): array
    {
        return array_map(fn (self $priority) => $priority->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::LOW->value => 'Low',
            self::MEDIUM->value => 'Medium',
            self::HIGH->value => 'High',
            self::CRITICAL->value => 'Critical',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::CRITICAL => 'danger',
        };
    }
}
