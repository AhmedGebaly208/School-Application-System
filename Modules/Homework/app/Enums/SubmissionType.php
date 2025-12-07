<?php

namespace Modules\Homework\Enums;

enum SubmissionType: string
{
    case FILE = 'file';
    case TEXT = 'text';
    case LINK = 'link';
    case NONE = 'none';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::FILE->value => 'File Upload',
            self::TEXT->value => 'Text Entry',
            self::LINK->value => 'Link/URL',
            self::NONE->value => 'No Submission Required',
        ];
    }
}
