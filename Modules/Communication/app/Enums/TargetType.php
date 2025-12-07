<?php

namespace Modules\Communication\Enums;

enum TargetType: string
{
    case GRADE = 'grade';
    case CLASS_LEVEL = 'class';
    case ROLE = 'role';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::GRADE->value => 'Grade',
            self::CLASS_LEVEL->value => 'Class',
            self::ROLE->value => 'Role',
        ];
    }
}
