<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

enum StackType: string
{
    case LARAVEL = 'laravel';
    case SYMFONY = 'symfony';
    case CRAFT_CMS = 'craft-cms';
    case STATAMIC = 'statamic';
    case WORDPRESS = 'wordpress';
}
