<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class GravCMSDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['getgrav/cache'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::GRAV_CMS;
    }
}
