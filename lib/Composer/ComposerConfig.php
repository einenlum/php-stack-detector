<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

readonly class ComposerConfig
{
    /** @param array<string, mixed> $content */
    public function __construct(public ComposerConfigType $type, public array $content)
    {
    }
}
