<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

class WinterCMSDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    public const string PACKAGE_NAME = 'winter/wn-cms-module';

    protected function packagesToSearch(): array
    {
        return [self::PACKAGE_NAME];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::WINTER_CMS;
    }
}
