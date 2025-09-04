<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\DTO;

use Fortrabbit\StackDetector\StackDetector\LunarDetector;
use Fortrabbit\StackDetector\StackDetector\OctoberCMSDetector;
use Fortrabbit\StackDetector\StackDetector\StatamicDetector;
use Fortrabbit\StackDetector\StackDetector\TwillDetector;
use Fortrabbit\StackDetector\StackDetector\WinterCMSDetector;

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
