<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\Exception;

class ResourceNotFoundException extends \RuntimeException
{
    public static function fromFullUri(string $fullUri): self
    {
        return new self(sprintf('Resource "%s" not found.', $fullUri));
    }
}
