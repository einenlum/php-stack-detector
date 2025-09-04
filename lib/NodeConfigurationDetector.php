<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;

class NodeConfigurationDetector
{
    public function __construct(private AdapterInterface $adapter)
    {
    }

    public function getNodeConfiguration(
        string $baseUri,
        ?string $subFolder = null,
    ): ?NodeConfiguration {
        return new NodeConfiguration(
            $this->getNodeVersion($baseUri, $subFolder),
            null,
        );
    }

    private function getNodeVersion(string $baseUri, ?string $subFolder = null): ?string
    {
        if (!$this->adapter->directoryExists($baseUri, $subFolder)) {
            return null;
        }

        $nvmrcContent = $this->getFileContent(
            $baseUri,
            $subFolder,
            '.nvmrc'
        );
        $nodeVersion = $this->extractNodeVersion($nvmrcContent);

        if (null !== $nodeVersion) {
            return $nodeVersion;
        }

        $nodeVersionContent = $this->getFileContent(
            $baseUri,
            $subFolder,
            '.node-version'
        );
        $nodeVersion = $this->extractNodeVersion($nodeVersionContent);

        return $nodeVersion;
    }

    private function extractNodeVersion(?string $content): ?string
    {
        if (null === $content) {
            return null;
        }

        $lines = explode("\n", trim($content));
        $lines = array_filter(
            $lines,
            fn ($line) => '' !== $line && false === str_starts_with($line, '#')
        );

        $firstLine = $lines[0] ?? null;

        if (null === $firstLine) {
            return null;
        }

        $version = ltrim($firstLine, 'v');

        return $version ?: null;
    }

    private function getFileContent(string $baseUri, ?string $subFolder, string $filename): ?string
    {
        try {
            return $this->adapter->getFileContent(
                $baseUri,
                $subFolder,
                $filename
            );
        } catch (ResourceNotFoundException) {
            return null;
        }
    }
}
