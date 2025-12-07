<?php

namespace Modules\Communication\Enums;

enum AnnouncementStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::ARCHIVED->value => 'Archived',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'success',
            self::ARCHIVED => 'warning',
        };
    }
}
