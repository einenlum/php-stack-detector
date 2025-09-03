<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\Stack;
use Einenlum\PhpStackDetector\StackType;

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
        $detectedStackType = $this->detectedStackType();

        if (null === $detectedStackType) {
            return null;
        }

        $version = $this->packageVersionProvider->getVersionForPackage(
            $baseUri,
            $subDirectory,
            $this->packagesToSearch()
        );

        return new Stack(
            $this->detectedStackType(),
            $version?->getVersion(),
        );
    }
}
