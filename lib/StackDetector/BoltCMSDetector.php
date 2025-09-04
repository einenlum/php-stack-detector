<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\StackDetector;

use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\Enum\StackType;

class BoltCMSDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['bolt/core'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::BOLT_CMS;
    }
}
