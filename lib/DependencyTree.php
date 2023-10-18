<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

class DependencyTree
{
    public const EXCLUSION_LIST = [
        'laravel/framework' => [
            'statamic/cms',
        ],
    ];

    /** @return string[] */
    public static function skipIfThesePackagesArePresent(string $packageName): array
    {
        return self::EXCLUSION_LIST[$packageName] ?? [];
    }
}
