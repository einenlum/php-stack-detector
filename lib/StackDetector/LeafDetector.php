<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

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
