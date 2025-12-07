<?php

namespace Modules\Counseling\Enums;

enum SessionStatus: string
{
    case SCHEDULED = 'scheduled';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::SCHEDULED->value => 'Scheduled',
            self::COMPLETED->value => 'Completed',
            self::CANCELLED->value => 'Cancelled',
            self::NO_SHOW->value => 'No Show',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'info',
            self::COMPLETED => 'success',
            self::CANCELLED => 'warning',
            self::NO_SHOW => 'danger',
        };
    }
}
