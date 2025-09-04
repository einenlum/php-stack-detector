<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\Enum\StackType;

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
