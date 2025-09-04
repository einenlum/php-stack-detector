<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

enum ComposerConfigType: string
{
    case JSON = 'json';
    case LOCK = 'lock';
}
