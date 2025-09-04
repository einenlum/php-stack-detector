<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO\Enum;

enum ComposerConfigType: string
{
    case JSON = 'json';
    case LOCK = 'lock';
}
