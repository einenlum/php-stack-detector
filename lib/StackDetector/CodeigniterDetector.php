<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\Enum\StackType;

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
