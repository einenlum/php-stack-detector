<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\Composer\PackageVersionProvider;
use fortrabbit\StackDetector\DTO\Stack;
use fortrabbit\StackDetector\Enum\StackType;

abstract class BaseComposerTypeDetector
{
    public function __construct(protected readonly PackageVersionProvider $packageVersionProvider)
    {
    }

    /**
     * @return string[]
     */
    abstract protected function packagesToSearch(): array;

    abstract protected function detectedStackType(): StackType;

    public function getStack(string $baseUri, ?string $subDirectory): ?Stack
    {
        $version = $this->packageVersionProvider->getVersionForPackage(
            $baseUri,
            $subDirectory,
            $this->packagesToSearch()
        );

        if (null === $version) {
            return null;
        }

        return new Stack(
            $this->detectedStackType(),
            $version->getVersion(),
        );
    }
}
