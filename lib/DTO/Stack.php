<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO;

use Fortrabbit\PhpStackDetector\Enum\StackType;

readonly class Stack
{
    public function __construct(
        public StackType $type,
        public ?string $version,
    ) {
    }
}
