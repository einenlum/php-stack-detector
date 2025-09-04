<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class CodeigniterDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['codeigniter4/framework'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::CODEIGNITER;
    }
}
