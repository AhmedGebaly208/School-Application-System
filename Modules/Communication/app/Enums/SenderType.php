<?php

namespace Modules\Communication\Enums;

enum SenderType: string
{
    case STAFF = 'staff';
    case PARENT = 'parent';
    case STUDENT = 'student';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::STAFF->value => 'Staff',
            self::PARENT->value => 'Parent',
            self::STUDENT->value => 'Student',
        ];
    }
}
