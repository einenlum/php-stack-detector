<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector;

use fortrabbit\StackDetector\DTO\Stack;

interface StackDetectorInterface
{
    public function getStack(string $baseUri, ?string $subDirectory): ?Stack;
}
