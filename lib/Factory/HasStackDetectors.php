<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\StackDetector\BoltCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\CakePhpDetector;
use Einenlum\PhpStackDetector\StackDetector\CodeigniterDetector;
use Einenlum\PhpStackDetector\StackDetector\DrupalDetector;
use Einenlum\PhpStackDetector\StackDetector\GravCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\LeafDetector;
use Einenlum\PhpStackDetector\StackDetector\LunarDetector;
use Einenlum\PhpStackDetector\StackDetector\OctoberCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\ShopwareDetector;
use Einenlum\PhpStackDetector\StackDetector\TempestDetector;
use Einenlum\PhpStackDetector\StackDetector\TwillDetector;
use Einenlum\PhpStackDetector\StackDetector\Typo3Detector;
use Einenlum\PhpStackDetector\StackDetector\WinterCMSDetector;
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
    private function getStackDetectors(
        ComposerConfigProvider $composerConfigProvider,
        AdapterInterface $adapter,
    ): array {
        $composerConfigProvider = new ComposerConfigProvider($adapter);
        $packageVersionProvider = new PackageVersionProvider($composerConfigProvider);

        return [
            new LaravelDetector($packageVersionProvider),
            new SymfonyDetector($packageVersionProvider),
            new CraftCMSDetector($packageVersionProvider),
            new WordpressDetector($adapter),
            new StatamicDetector($packageVersionProvider),
            new BoltCMSDetector($packageVersionProvider),
            new CakePhpDetector($packageVersionProvider),
            new CodeigniterDetector($packageVersionProvider),
            new DrupalDetector($packageVersionProvider),
            new GravCMSDetector($packageVersionProvider),
            new LeafDetector($packageVersionProvider),
            new LunarDetector($packageVersionProvider),
            new OctoberCMSDetector($packageVersionProvider),
            new ShopwareDetector($packageVersionProvider),
            new TempestDetector($packageVersionProvider),
            new TwillDetector($packageVersionProvider),
            new Typo3Detector($packageVersionProvider),
            new WinterCMSDetector($packageVersionProvider),
        ];
    }
}
