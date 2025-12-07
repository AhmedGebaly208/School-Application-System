<?php

namespace Modules\Administration\Enums;

enum AuditAction: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case VIEW = 'view';

    public static function values(): array
    {
        return array_map(fn (self $action) => $action->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::CREATE->value => 'Create',
            self::UPDATE->value => 'Update',
            self::DELETE->value => 'Delete',
            self::LOGIN->value => 'Login',
            self::LOGOUT->value => 'Logout',
            self::VIEW->value => 'View',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::CREATE => 'success',
            self::UPDATE => 'info',
            self::DELETE => 'danger',
            self::LOGIN => 'success',
            self::LOGOUT => 'warning',
            self::VIEW => 'gray',
        };
    }
}
