<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

class SymfonyDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['symfony/framework-bundle', 'symfony/symfony'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::SYMFONY;
    }
}
