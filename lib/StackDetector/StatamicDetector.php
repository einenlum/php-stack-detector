<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\Stack;
use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

class StatamicDetector implements StackDetectorInterface
{
    public function __construct(private readonly PackageVersionProvider $packageVersionProvider)
    {
    }

    public function getStack(string $baseUri, ?string $subDirectory): ?Stack
    {
        $version = $this->packageVersionProvider->getVersionForPackage(
            $baseUri,
            $subDirectory,
            'statamic/cms',
        );

        if (null === $version) {
            return null;
        }

        return new Stack(
            StackType::STATAMIC,
            $version->getVersion(),
        );
    }
}
