<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackDetector\CraftCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\LaravelDetector;
use Einenlum\PhpStackDetector\StackDetector\StatamicDetector;
use Einenlum\PhpStackDetector\StackDetector\SymfonyDetector;
use Einenlum\PhpStackDetector\StackDetector\WordpressDetector;
use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;

trait HasStackDetectors
{
    /** @return StackDetectorInterface[] */
    private function getStackDetectors(AdapterInterface $adapter): array
    {
        $composerConfigProvider = new ComposerConfigProvider($adapter);
        $packageVersionProvider = new PackageVersionProvider($composerConfigProvider);

        return [
            new LaravelDetector($packageVersionProvider),
            new SymfonyDetector($packageVersionProvider),
            new CraftCMSDetector($packageVersionProvider),
            new WordpressDetector($adapter),
            new StatamicDetector($packageVersionProvider),
        ];
    }
}
