<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\DirectoryCrawler;

use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;

interface AdapterInterface
{
    /** @throws ResourceNotFoundException */
    public function getFileContent(string $baseUri, ?string ...$pathTree): string;

    public function directoryExists(string $baseUri, ?string ...$pathTree): bool;

    /** @return array<int, null|string> */
    public function listFilesInDirectory(string $baseUri, ?string ...$pathTree): array;
}
