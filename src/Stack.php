<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class Stack
{
    public function __construct(
        public StackType $type,
        public ?string $version,
    ) {
    }
}
