<?php

namespace App\Domain\Product\Enums;


use App\Infrastructure\Enums\BaseEnumTrait;
use App\Infrastructure\Interfaces\IEnum;

enum OutputExport: string implements IEnum
{
    use BaseEnumTrait;

    case JSON = 'json';
    case XML = 'xml';
}
