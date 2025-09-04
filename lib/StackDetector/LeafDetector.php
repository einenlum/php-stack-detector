<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class LeafDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['leafs/leaf', 'leafs/mvc'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::LEAF_PHP;
    }
}
