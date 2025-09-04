<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\DTO;

use Fortrabbit\StackDetector\Enum\NodePackageManagerType;

readonly class NodeConfiguration
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
        public NodePackageManagerType $packageManager,
    ) {
    }
}
