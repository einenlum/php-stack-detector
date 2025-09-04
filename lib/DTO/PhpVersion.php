<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO;

readonly class PhpVersion
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
    ) {
    }
}
