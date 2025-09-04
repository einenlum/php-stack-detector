<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\DTO\Composer;

use Einenlum\PhpStackDetector\DTO\Enum\ComposerConfigType;

readonly class ComposerConfig
{
    /** @param array<string, mixed> $content */
    public function __construct(public ComposerConfigType $type, public array $content)
    {
    }
}
