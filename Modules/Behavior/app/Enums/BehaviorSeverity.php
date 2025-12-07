<?php

namespace Modules\Behavior\Enums;

enum BehaviorSeverity: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public static function values(): array
    {
        return array_map(fn (self $severity) => $severity->value, self::cases());
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

    public function points(): int
    {
        return match($this) {
            self::LOW => 1,
            self::MEDIUM => 3,
            self::HIGH => 5,
            self::CRITICAL => 10,
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::LOW => 'bg-blue-100 text-blue-800',
            self::MEDIUM => 'bg-yellow-100 text-yellow-800',
            self::HIGH => 'bg-orange-100 text-orange-800',
            self::CRITICAL => 'bg-red-100 text-red-800',
        };
    }
}
