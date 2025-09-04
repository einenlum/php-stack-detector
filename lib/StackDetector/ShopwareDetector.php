<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\Enum\StackType;

class ShopwareDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['shopware/core'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::SHOPWARE;
    }
}
