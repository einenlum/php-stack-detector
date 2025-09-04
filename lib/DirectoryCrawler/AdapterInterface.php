<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\DirectoryCrawler;

use Fortrabbit\StackDetector\Exception\ResourceNotFoundException;

interface AdapterInterface
{
    /** @throws ResourceNotFoundException */
    public function getFileContent(string $baseUri, ?string ...$pathTree): string;

    public function fileExists(string $baseUri, ?string ...$pathTree): bool;

    public function directoryExists(string $baseUri, ?string ...$pathTree): bool;

    /** @return array<int, string|null> */
    public function listFilesInDirectory(string $baseUri, ?string ...$pathTree): array;
}
