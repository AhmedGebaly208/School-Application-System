<?php

namespace Modules\Communication\Enums;

enum AnnouncementTargetAudience: string
{
    case ALL = 'all';
    case STUDENTS = 'students';
    case PARENTS = 'parents';
    case STAFF = 'staff';
    case SPECIFIC = 'specific';

    public static function values(): array
    {
        return array_map(fn (self $audience) => $audience->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::ALL->value => 'All',
            self::STUDENTS->value => 'Students',
            self::PARENTS->value => 'Parents',
            self::STAFF->value => 'Staff',
            self::SPECIFIC->value => 'Specific',
        ];
    }
}
