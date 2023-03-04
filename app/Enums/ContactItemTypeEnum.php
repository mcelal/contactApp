<?php

namespace App\Enums;

use BackedEnum;
enum ContactItemTypeEnum: string
{
    case PHONE = 'Phone';
    case EMAIL = 'Email';
    case LOCATION = 'Location';

    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }
}
