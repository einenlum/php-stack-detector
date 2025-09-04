<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\DTO\Composer;

use Fortrabbit\StackDetector\DTO\Enum\ComposerConfigType;

readonly class ComposerConfig
{
    /** @param array<string, mixed> $content */
    public function __construct(public ComposerConfigType $type, public array $content)
    {
    }
}
