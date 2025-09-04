<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class Typo3Detector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['typo3/cms-core'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::TYPO3_CMS;
    }
}
