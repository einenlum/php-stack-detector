<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\DirectoryCrawler;

use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;

class FilesystemAdapter implements AdapterInterface
{
    /** {@inheritdoc} */
    public function getFileContent(string $baseUri, ?string ...$pathTree): string
    {
        $fullUri = $this->getFullUri($baseUri, $pathTree);

        if (!is_file($fullUri)) {
            throw ResourceNotFoundException::fromFullUri($fullUri);
        }

        /** @var string */
        $content = file_get_contents($fullUri);


        return $content;
    }

    public function directoryExists(string $baseUri, ?string ...$pathTree): bool
    {
        $fullUri = $this->getFullUri($baseUri, $pathTree);

        return is_dir($fullUri);
    }

    /** {@inheritdoc} */
    public function listFilesInDirectory(string $baseUri, ?string ...$pathTree): array
    {
        if (!$this->directoryExists($baseUri, ...$pathTree)) {
            return [];
        }

        $fullUri = $this->getFullUri($baseUri, $pathTree);

        /** @var string[] */
        $files = scandir($fullUri);

        return array_values(array_diff($files, ['..', '.']));
    }

    /** @param (null|string)[] $pathTree */
    private function getFullUri(string $baseUri, array $pathTree): string
    {
        $pathTree = array_filter($pathTree);
        $paths = array_merge([$baseUri], $pathTree);

        return implode(\DIRECTORY_SEPARATOR, $paths);
    }
}
