<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\DTO;

use Einenlum\PhpStackDetector\StackType;

readonly class Stack
{
    public function __construct(
        public StackType $type,
        public ?string $version,
    ) {
    }
}
