<?php

namespace Modules\Communication\Enums;

enum AnnouncementType: string
{
    case SCHOOL_WIDE = 'school_wide';
    case GRADE = 'grade';
    case CLASS_LEVEL = 'class';
    case DEPARTMENT = 'department';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::SCHOOL_WIDE->value => 'School Wide',
            self::GRADE->value => 'Grade',
            self::CLASS_LEVEL->value => 'Class',
            self::DEPARTMENT->value => 'Department',
        ];
    }
}
