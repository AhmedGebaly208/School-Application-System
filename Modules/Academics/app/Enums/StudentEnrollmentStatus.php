<?php

namespace Modules\Academics\Enums;

enum StudentEnrollmentStatus: string
{
    case Active = 'active';
    case Transferred = 'transferred';
    case Completed = 'completed';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::Active->value => 'Active',
            self::Transferred->value => 'Transferred',
            self::Completed->value => 'Completed',
        ];
    }
}
