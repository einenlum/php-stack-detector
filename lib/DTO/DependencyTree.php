<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

use fortrabbit\StackDetector\StackDetector\LunarDetector;
use fortrabbit\StackDetector\StackDetector\OctoberCMSDetector;
use fortrabbit\StackDetector\StackDetector\StatamicDetector;
use fortrabbit\StackDetector\StackDetector\TwillDetector;
use fortrabbit\StackDetector\StackDetector\WinterCMSDetector;

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
