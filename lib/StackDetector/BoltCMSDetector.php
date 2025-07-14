<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

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
