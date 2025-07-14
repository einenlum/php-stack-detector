<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\StackDetector\LunarDetector;
use Einenlum\PhpStackDetector\StackDetector\OctoberCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\StatamicDetector;
use Einenlum\PhpStackDetector\StackDetector\TwillDetector;
use Einenlum\PhpStackDetector\StackDetector\WinterCMSDetector;

class DependencyTree
{
    public const array CHILDREN_STACKS = [
        'laravel/framework' => [
            StatamicDetector::PACKAGE_NAME,
            OctoberCMSDetector::PACKAGE_NAME,
            LunarDetector::PACKAGE_NAME,
            TwillDetector::PACKAGE_NAME,
            WinterCMSDetector::PACKAGE_NAME,
        ],
    ];

    /** @return string[] */
    public static function getChildStacksForPackage(string $packageName): array
    {
        return self::CHILDREN_STACKS[$packageName] ?? [];
    }
}
