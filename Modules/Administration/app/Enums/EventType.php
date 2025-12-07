<?php

namespace Modules\Administration\Enums;

enum EventType: string
{
    case EXAM = 'exam';
    case ACTIVITY = 'activity';
    case MEETING = 'meeting';
    case CEREMONY = 'ceremony';
    case SPORTS = 'sports';
    case CULTURAL = 'cultural';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::EXAM->value => 'Exam',
            self::ACTIVITY->value => 'Activity',
            self::MEETING->value => 'Meeting',
            self::CEREMONY->value => 'Ceremony',
            self::SPORTS->value => 'Sports Event',
            self::CULTURAL->value => 'Cultural Event',
        ];
    }
}
