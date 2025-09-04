<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO;

use Fortrabbit\PhpStackDetector\StackDetector\LunarDetector;
use Fortrabbit\PhpStackDetector\StackDetector\OctoberCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetector\StatamicDetector;
use Fortrabbit\PhpStackDetector\StackDetector\TwillDetector;
use Fortrabbit\PhpStackDetector\StackDetector\WinterCMSDetector;

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
