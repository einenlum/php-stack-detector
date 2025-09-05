<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

readonly class PhpConfiguration
{
    public function __construct(
        public ?PhpVersion $phpVersion,
        /** @var string[] */
        public array $requiredExtensions = [],
        /** @var array<string, mixed>|null */
        public ?array $composerJsonContent = null,
        /** @var array<string, mixed>|null */
        public ?array $composerLockContent = null,
    ) {
    }
}
