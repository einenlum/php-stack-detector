<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

enum ComposerConfigType
{
    case JSON;
    case LOCK;
}
