<?php

namespace Modules\Administration\Enums;

enum LeaveType: string
{
    case SICK = 'sick';
    case ANNUAL = 'annual';
    case EMERGENCY = 'emergency';
    case UNPAID = 'unpaid';
    case MATERNITY = 'maternity';
    case PATERNITY = 'paternity';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::SICK->value => 'Sick Leave',
            self::ANNUAL->value => 'Annual Leave',
            self::EMERGENCY->value => 'Emergency Leave',
            self::UNPAID->value => 'Unpaid Leave',
            self::MATERNITY->value => 'Maternity Leave',
            self::PATERNITY->value => 'Paternity Leave',
        ];
    }
}
