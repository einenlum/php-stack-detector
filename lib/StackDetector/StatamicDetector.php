<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class StatamicDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    public const string PACKAGE_NAME = 'statamic/cms';

    protected function packagesToSearch(): array
    {
        return [self::PACKAGE_NAME];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::STATAMIC;
    }
}
