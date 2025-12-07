<?php

namespace Modules\Counseling\Enums;

enum CaseStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';
    case ESCALATED = 'escalated';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::OPEN->value => 'Open',
            self::IN_PROGRESS->value => 'In Progress',
            self::CLOSED->value => 'Closed',
            self::ESCALATED->value => 'Escalated',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'info',
            self::IN_PROGRESS => 'warning',
            self::CLOSED => 'success',
            self::ESCALATED => 'danger',
        };
    }
}
