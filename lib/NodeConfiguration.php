<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

class NodeConfiguration
{
    public function __construct(
        public readonly ?string $version,
        public readonly ?string $packageManager,
    ) {
    }
}
