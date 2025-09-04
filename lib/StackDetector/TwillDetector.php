<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

class TwillDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    public const string PACKAGE_NAME = 'area17/twill';

    protected function packagesToSearch(): array
    {
        return [self::PACKAGE_NAME];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::TWILL;
    }
}
