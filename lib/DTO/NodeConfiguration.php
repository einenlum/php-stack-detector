<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

use fortrabbit\StackDetector\Enum\NodePackageManagerType;

readonly class NodeConfiguration
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
        public NodePackageManagerType $packageManager,
    ) {
    }
}
