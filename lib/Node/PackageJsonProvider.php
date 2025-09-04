<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Node;

use Fortrabbit\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Fortrabbit\PhpStackDetector\Exception\CacheMissException;
use Fortrabbit\PhpStackDetector\Exception\ResourceNotFoundException;

class PackageJsonProvider
{
    /** @var array<string, mixed|null> */
    private array $cache = [];

    public function __construct(
        private readonly AdapterInterface $adapter,
    ) {
    }

    /** @return array<string, mixed>|null */
    public function getPackageJsonConfig(
        string $baseUri,
        ?string $subDirectory,
    ): ?array {
        try {
            return $this->getFromCache($baseUri, $subDirectory);
        } catch (CacheMissException) {
        }

        $content = $this->getFileContent(
            $baseUri,
            $subDirectory,
        );

        $this->setToCache($baseUri, $subDirectory, $content);

        return $content;
    }

    /** @return array<string, mixed>|null */
    private function getFileContent(
        string $baseUri,
        ?string $subDirectory,
    ): ?array {
        if (!$this->adapter->directoryExists($baseUri, $subDirectory)) {
            return null;
        }

        try {
            $fileContent = $this->adapter->getFileContent(
                $baseUri,
                $subDirectory,
                'package.json'
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

    /** @param array<string, mixed>|null $config */
    private function setToCache(
        string $baseUri,
        ?string $subDirectory,
        ?array $config,
    ): void {
        $cacheKey = $this->getCacheKey($baseUri, $subDirectory);

        $this->cache[$cacheKey] = $config;
    }

    /**
     * @return array<string, mixed>|null
     *
     * @throws CacheMissException
     */
    private function getFromCache(
        string $baseUri,
        ?string $subDirectory,
    ): ?array {
        $cacheKey = $this->getCacheKey($baseUri, $subDirectory);

        if (!array_key_exists($cacheKey, $this->cache)) {
            throw new CacheMissException();
        }

        return $this->cache[$cacheKey];
    }

    private function getCacheKey(
        string $baseUri,
        ?string $subDirectory,
    ): string {
        return $baseUri.$subDirectory;
    }
}
