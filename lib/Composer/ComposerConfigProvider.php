<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;

class ComposerConfigProvider
{
    public function __construct(private AdapterInterface $adapter)
    {
    }

    public function getComposerConfig(
        string $baseUri,
        ?string $subDirectory,
    ): ?ComposerConfig {
        $lockContent = $this->getConfig(
            $baseUri,
            $subDirectory,
            'composer.lock'
        );

        if (null !== $lockContent) {
            return new ComposerConfig(
                ComposerConfigType::LOCK,
                $lockContent
            );
        }

        $jsonContent = $this->getConfig(
            $baseUri,
            $subDirectory,
            'composer.json'
        );

        if (null !== $jsonContent) {
            return new ComposerConfig(
                ComposerConfigType::JSON,
                $jsonContent
            );
        }

        return null;
    }

    /** @return array<string, mixed>|null */
    private function getConfig(string $baseUri, ?string $subDirectory, string $filename): ?array
    {
        if (!$this->adapter->directoryExists($baseUri, $subDirectory)) {
            return null;
        }

        try {
            $fileContent = $this->adapter->getFileContent(
                $baseUri,
                $subDirectory,
                $filename
            );
        } catch (ResourceNotFoundException $e) {
            return null;
        }

        $decoded = json_decode($fileContent, true);
        if (null === $decoded) {
            return null;
        }

        return $decoded;
    }
}
