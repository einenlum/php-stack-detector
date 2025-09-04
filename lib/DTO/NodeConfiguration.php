<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\DTO;

use Fortrabbit\PhpStackDetector\Enum\NodePackageManagerType;

readonly class NodeConfiguration
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
        public NodePackageManagerType $packageManager,
    ) {
    }
}
