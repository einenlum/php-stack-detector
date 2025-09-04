<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

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
