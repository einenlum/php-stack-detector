<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

class DrupalDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['drupal/core'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::DRUPAL;
    }
}
