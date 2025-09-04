<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

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
