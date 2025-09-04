<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO\Composer;

use fortrabbit\StackDetector\DTO\Enum\ComposerConfigType;

readonly class ComposerConfig
{
    /** @param array<string, mixed> $content */
    public function __construct(public ComposerConfigType $type, public array $content)
    {
    }
}
