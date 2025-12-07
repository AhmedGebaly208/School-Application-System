<?php

namespace Modules\Timetable\Enums;

enum RoomType: string
{
    case CLASSROOM = 'classroom';
    case LAB = 'lab';
    case LIBRARY = 'library';
    case GYM = 'gym';
    case AUDITORIUM = 'auditorium';
    case OFFICE = 'office';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::CLASSROOM->value => 'Classroom',
            self::LAB->value => 'Laboratory',
            self::LIBRARY->value => 'Library',
            self::GYM->value => 'Gymnasium',
            self::AUDITORIUM->value => 'Auditorium',
            self::OFFICE->value => 'Office',
        ];
    }
}
