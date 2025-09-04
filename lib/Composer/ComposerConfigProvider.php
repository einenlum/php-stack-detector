<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Composer;

use Fortrabbit\PhpStackDetector\DTO\Composer\ComposerConfig;
use Fortrabbit\PhpStackDetector\DTO\Enum\ComposerConfigType;
use Fortrabbit\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Fortrabbit\PhpStackDetector\Exception\CacheMissException;
use Fortrabbit\PhpStackDetector\Exception\ResourceNotFoundException;

/**
 * We use an array cache so that we don't make expensive calls to the adapter
 * each time. This provider is used in multiple places during a single run.
 */
class ComposerConfigProvider
{
    /** @var array<string, ComposerConfig|null> */
    private array $cache = [];

    public function __construct(
        private readonly AdapterInterface $adapter,
    ) {
    }

    public function getComposerConfig(
        ComposerConfigType $type,
        string $baseUri,
        ?string $subDirectory,
    ): ?ComposerConfig {
        try {
            return $this->getFromCache($type, $baseUri, $subDirectory);
        } catch (CacheMissException) {
        }

        $content = $this->getFileContent(
            $type,
            $baseUri,
            $subDirectory,
        );

        $config = $content ? new ComposerConfig($type, $content) : null;

        $this->setToCache($type, $baseUri, $subDirectory, $config);

        return $config;
    }

    /** @return array<string, mixed>|null */
    private function getFileContent(
        ComposerConfigType $type,
        string $baseUri,
        ?string $subDirectory,
    ): ?array {
        $filename = ComposerConfigType::LOCK === $type ? 'composer.lock' : 'composer.json';

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
        ComposerConfigType $type,
        string $baseUri,
        ?string $subDirectory,
        ?ComposerConfig $config,
    ): void {
        $cacheKey = $this->getCacheKey($type, $baseUri, $subDirectory);

        $this->cache[$cacheKey] = $config;
    }

    /**
     * @throws CacheMissException
     */
    private function getFromCache(
        ComposerConfigType $type,
        string $baseUri,
        ?string $subDirectory,
    ): ?ComposerConfig {
        $cacheKey = $this->getCacheKey($type, $baseUri, $subDirectory);

        if (!array_key_exists($cacheKey, $this->cache)) {
            throw new CacheMissException();
        }

        return $this->cache[$cacheKey];
    }

    private function getCacheKey(
        ComposerConfigType $type,
        string $baseUri,
        ?string $subDirectory,
    ): string {
        return $baseUri.$subDirectory.':'.$type->value;
    }
}
