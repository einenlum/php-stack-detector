<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class NodeConfiguration
{
    public function __construct(
        public ?string $version,
        public ?string $requirements,
        public NodePackageManagerType $packageManager,
    ) {
    }
}
