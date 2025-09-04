<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO;

readonly class PhpConfiguration
{
    public function __construct(
        public ?PhpVersion $phpVersion,
        /** @var string[] $requiredExtensions */
        public array $requiredExtensions = [],
    ) {
    }
}
