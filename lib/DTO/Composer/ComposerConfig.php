<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO\Composer;

use Fortrabbit\PhpStackDetector\DTO\Enum\ComposerConfigType;

readonly class ComposerConfig
{
    /** @param array<string, mixed> $content */
    public function __construct(public ComposerConfigType $type, public array $content)
    {
    }
}
