<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector;

use Fortrabbit\StackDetector\DTO\Stack;

interface StackDetectorInterface
{
    public function getStack(string $baseUri, ?string $subDirectory): ?Stack;
}
