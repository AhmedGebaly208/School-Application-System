<?php

namespace Modules\Attendance\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LATE = 'late';
    case EXCUSED = 'excused';
    case EARLY_LEAVE = 'early_leave';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::PRESENT->value => 'Present',
            self::ABSENT->value => 'Absent',
            self::LATE->value => 'Late',
            self::EXCUSED->value => 'Excused',
            self::EARLY_LEAVE->value => 'Early Leave',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::PRESENT => 'success',
            self::ABSENT => 'danger',
            self::LATE => 'warning',
            self::EXCUSED => 'info',
            self::EARLY_LEAVE => 'warning',
        };
    }
}
