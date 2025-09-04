<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

use fortrabbit\StackDetector\Enum\StackType;

readonly class Stack
{
    public function __construct(
        public StackType $type,
        public ?string $version,
    ) {
    }
}
