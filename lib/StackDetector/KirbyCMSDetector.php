<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\Enum\StackType;
use fortrabbit\StackDetector\StackDetectorInterface;

class KirbyCMSDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['getkirby/cms'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::KIRBY_CMS;
    }
}
