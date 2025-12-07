<?php

namespace Modules\Administration\Enums;

enum SettingGroup: string
{
    case GENERAL = 'general';
    case ACADEMIC = 'academic';
    case FINANCIAL = 'financial';
    case NOTIFICATION = 'notification';
    case SECURITY = 'security';

    public static function values(): array
    {
        return array_map(fn (self $group) => $group->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::GENERAL->value => 'General',
            self::ACADEMIC->value => 'Academic',
            self::FINANCIAL->value => 'Financial',
            self::NOTIFICATION->value => 'Notification',
            self::SECURITY->value => 'Security',
        ];
    }
}
