<?php

namespace App\Infrastructure\Enums;

use App\Infrastructure\Interfaces\IEnum;

enum StatusEnum: string implements IEnum
{
    use BaseEnumTrait;

    case PUBLISHED = '1';
    case INACTIVATED = '2';
    case DRAFTED = '3';
    case ARCHIVED = '4';


    /**
     * @return string
     */
    public static function getPrefix(): string
    {
        return 'enums.';
    }
}
