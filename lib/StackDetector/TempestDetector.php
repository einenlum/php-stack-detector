<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\StackDetector;

use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\Enum\StackType;

class TempestDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['tempest/framework'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::TEMPEST;
    }
}
