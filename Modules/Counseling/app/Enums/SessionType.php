<?php

namespace Modules\Counseling\Enums;

enum SessionType: string
{
    case INDIVIDUAL = 'individual';
    case GROUP = 'group';
    case PARENT = 'parent';
    case EMERGENCY = 'emergency';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::INDIVIDUAL->value => 'Individual',
            self::GROUP->value => 'Group',
            self::PARENT->value => 'Parent Meeting',
            self::EMERGENCY->value => 'Emergency',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::INDIVIDUAL => 'info',
            self::GROUP => 'success',
            self::PARENT => 'warning',
            self::EMERGENCY => 'danger',
        };
    }
}
