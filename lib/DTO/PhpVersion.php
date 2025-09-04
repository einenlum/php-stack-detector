<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

readonly class PhpVersion
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
    ) {
    }
}
