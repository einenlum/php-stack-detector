<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector;

use Fortrabbit\PhpStackDetector\DTO\Stack;

interface StackDetectorInterface
{
    public function getStack(string $baseUri, ?string $subDirectory): ?Stack;
}
