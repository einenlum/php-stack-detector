<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

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
