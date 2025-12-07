<?php

namespace Modules\Administration\Enums;

enum StaffAttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case ON_LEAVE = 'on_leave';
    case HALF_DAY = 'half_day';
    case LATE = 'late';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::PRESENT->value => 'Present',
            self::ABSENT->value => 'Absent',
            self::ON_LEAVE->value => 'On Leave',
            self::HALF_DAY->value => 'Half Day',
            self::LATE->value => 'Late',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::PRESENT => 'success',
            self::ABSENT => 'danger',
            self::ON_LEAVE => 'warning',
            self::HALF_DAY => 'info',
            self::LATE => 'warning',
        };
    }
}
