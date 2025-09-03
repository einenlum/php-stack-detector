<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class PhpVersion
{
    public function __construct(
        public ?string $version,
        public ?string $requirement,
    ) {
    }
}
