<?php

namespace Modules\Counseling\Enums;

enum CaseType: string
{
    case COUNSELING = 'counseling';
    case SOCIAL = 'social';
    case PSYCHOLOGICAL = 'psychological';
    case BEHAVIORAL = 'behavioral';
    case ACADEMIC = 'academic';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::COUNSELING->value => 'Counseling',
            self::SOCIAL->value => 'Social',
            self::PSYCHOLOGICAL->value => 'Psychological',
            self::BEHAVIORAL->value => 'Behavioral',
            self::ACADEMIC->value => 'Academic',
        ];
    }
}
