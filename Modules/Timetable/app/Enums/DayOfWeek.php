<?php

namespace Modules\Timetable\Enums;

enum DayOfWeek: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';

    public static function values(): array
    {
        return array_map(fn (self $day) => $day->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::MONDAY->value => 'Monday',
            self::TUESDAY->value => 'Tuesday',
            self::WEDNESDAY->value => 'Wednesday',
            self::THURSDAY->value => 'Thursday',
            self::FRIDAY->value => 'Friday',
            self::SATURDAY->value => 'Saturday',
            self::SUNDAY->value => 'Sunday',
        ];
    }

    public function order(): int
    {
        return match($this) {
            self::MONDAY => 1,
            self::TUESDAY => 2,
            self::WEDNESDAY => 3,
            self::THURSDAY => 4,
            self::FRIDAY => 5,
            self::SATURDAY => 6,
            self::SUNDAY => 7,
        };
    }
}
