<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

readonly class FullConfiguration
{
    public function __construct(
        public PhpConfiguration $phpConfiguration,
        public ?NodeConfiguration $nodeConfiguration,
        public ?Stack $stack,
    ) {
    }
}
