<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\DTO\Stack;

interface StackDetectorInterface
{
    public function getStack(string $baseUri, ?string $subDirectory): ?Stack;
}
