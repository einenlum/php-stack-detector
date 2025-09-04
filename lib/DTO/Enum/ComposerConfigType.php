<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO\Enum;

enum ComposerConfigType: string
{
    case JSON = 'json';
    case LOCK = 'lock';
}
