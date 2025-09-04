<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class FullConfiguration
{
    public function __construct(
        public PhpConfiguration $phpConfiguration,
        public ?NodeConfiguration $nodeConfiguration,
        public ?Stack $stack,
    ) {
    }
}
