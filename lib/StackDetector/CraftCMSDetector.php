<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

class CraftCMSDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['craftcms/cms'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::CRAFT_CMS;
    }
}
