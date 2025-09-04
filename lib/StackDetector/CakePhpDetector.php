<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\StackDetector;

use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\Enum\StackType;

class CakePhpDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['cakephp/cakephp'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::CAKE_PHP;
    }
}
