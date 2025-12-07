<?php

namespace Modules\Administration\Enums;

enum SettingType: string
{
    case STRING = 'string';
    case INTEGER = 'integer';
    case BOOLEAN = 'boolean';
    case JSON = 'json';
    case ARRAY = 'array';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::STRING->value => 'String',
            self::INTEGER->value => 'Integer',
            self::BOOLEAN->value => 'Boolean',
            self::JSON->value => 'JSON',
            self::ARRAY->value => 'Array',
        ];
    }
}
