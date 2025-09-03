<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Einenlum\PhpStackDetector\Exception\CacheMissException;
use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;

class ComposerConfigProvider
{
    /** @var array<string, ComposerConfig|null> */
    private array $cache = [];

    public function __construct(
        private readonly AdapterInterface $adapter,
    ) {
    }

    public function getComposerConfig(
        string $baseUri,
        ?string $subDirectory,
    ): ?ComposerConfig {
        try {
            return $this->getFromCache($baseUri, $subDirectory);
        } catch (CacheMissException) {
        }

        $lockContent = $this->getFileContent(
            $baseUri,
            $subDirectory,
            'composer.lock'
        );

        if (null !== $lockContent) {
            $config = new ComposerConfig(
                ComposerConfigType::LOCK,
                $lockContent
            );
            $this->setToCache($baseUri, $subDirectory, $config);

            return $config;
        }

        $jsonContent = $this->getFileContent(
            $baseUri,
            $subDirectory,
            'composer.json'
        );

        if (null !== $jsonContent) {
            $config = new ComposerConfig(
                ComposerConfigType::JSON,
                $jsonContent
            );

            $this->setToCache($baseUri, $subDirectory, $config);

            return $config;
        }

        $this->setToCache($baseUri, $subDirectory, null);

        return null;
    }

    /** @return array<string, mixed>|null */
    private function getFileContent(string $baseUri, ?string $subDirectory, string $filename): ?array
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

    private function setToCache(
        string $baseUri,
        ?string $subDirectory,
        ?ComposerConfig $config,
    ): void {
        $cacheKey = $this->getCacheKey($baseUri, $subDirectory);

        $this->cache[$cacheKey] = $config;
    }

    /**
     * @throws CacheMissException
     */
    private function getFromCache(string $baseUri, ?string $subDirectory): ?ComposerConfig
    {
        $cacheKey = $this->getCacheKey($baseUri, $subDirectory);

        if (!array_key_exists($cacheKey, $this->cache)) {
            throw new CacheMissException();
        }

        return $this->cache[$cacheKey];
    }

    private function getCacheKey(string $baseUri, ?string $subDirectory): string
    {
        return $baseUri.$subDirectory;
    }
}
