<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\Stack;
use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

class LaravelDetector implements StackDetectorInterface
{
    public function __construct(private PackageVersionProvider $packageVersionProvider)
    {
    }

    public function getStack(string $folderPath): ?Stack
    {
        $version = $this->packageVersionProvider->getVersionForPackage(
            $folderPath,
            'laravel/framework',
        );

        if (null === $version) {
            return null;
        }

        return new Stack(
            StackType::LARAVEL,
            $version->getVersion(),
        );
    }
}
