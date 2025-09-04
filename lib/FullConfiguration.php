<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\DTO\Stack;

readonly class FullConfiguration
{
    public function __construct(
        public PhpConfiguration $phpConfiguration,
        public ?NodeConfiguration $nodeConfiguration,
        public ?Stack $stack,
    ) {
    }
}
