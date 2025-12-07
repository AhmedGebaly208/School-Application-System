<?php

namespace Modules\Administration\Enums;

enum HolidayType: string
{
    case PUBLIC = 'public';
    case SCHOOL = 'school';
    case RELIGIOUS = 'religious';
    case TERM_BREAK = 'term_break';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::PUBLIC->value => 'Public Holiday',
            self::SCHOOL->value => 'School Holiday',
            self::RELIGIOUS->value => 'Religious Holiday',
            self::TERM_BREAK->value => 'Term Break',
        ];
    }
}
