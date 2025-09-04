<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\Enum\StackType;

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
