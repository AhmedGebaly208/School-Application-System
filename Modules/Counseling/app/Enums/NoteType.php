<?php

namespace Modules\Counseling\Enums;

enum NoteType: string
{
    case OBSERVATION = 'observation';
    case INTERVENTION = 'intervention';
    case MEETING = 'meeting';
    case FOLLOW_UP = 'follow_up';
    case RESOLUTION = 'resolution';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::OBSERVATION->value => 'Observation',
            self::INTERVENTION->value => 'Intervention',
            self::MEETING->value => 'Meeting',
            self::FOLLOW_UP->value => 'Follow-up',
            self::RESOLUTION->value => 'Resolution',
        ];
    }
}
