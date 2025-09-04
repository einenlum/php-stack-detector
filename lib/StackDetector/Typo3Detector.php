<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\StackDetector;

use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\Enum\StackType;

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
