<?php

namespace Modules\Communication\Enums;

enum AnnouncementPriority: string
{
    case NORMAL = 'normal';
    case IMPORTANT = 'important';
    case URGENT = 'urgent';

    public static function values(): array
    {
        return array_map(fn (self $priority) => $priority->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::NORMAL->value => 'Normal',
            self::IMPORTANT->value => 'Important',
            self::URGENT->value => 'Urgent',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::NORMAL => 'info',
            self::IMPORTANT => 'warning',
            self::URGENT => 'danger',
        };
    }
}
