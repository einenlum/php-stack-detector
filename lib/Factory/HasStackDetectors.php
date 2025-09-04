<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\Factory;

use Fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\StackDetector\Composer\PackageVersionProvider;
use Fortrabbit\StackDetector\StackDetector\BoltCMSDetector;
use Fortrabbit\StackDetector\StackDetector\CakePhpDetector;
use Fortrabbit\StackDetector\StackDetector\CodeigniterDetector;
use Fortrabbit\StackDetector\StackDetector\DrupalDetector;
use Fortrabbit\StackDetector\StackDetector\GravCMSDetector;
use Fortrabbit\StackDetector\StackDetector\LeafDetector;
use Fortrabbit\StackDetector\StackDetector\LunarDetector;
use Fortrabbit\StackDetector\StackDetector\OctoberCMSDetector;
use Fortrabbit\StackDetector\StackDetector\ShopwareDetector;
use Fortrabbit\StackDetector\StackDetector\TempestDetector;
use Fortrabbit\StackDetector\StackDetector\TwillDetector;
use Fortrabbit\StackDetector\StackDetector\Typo3Detector;
use Fortrabbit\StackDetector\StackDetector\WinterCMSDetector;
use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\StackDetector\CraftCMSDetector;
use Fortrabbit\StackDetector\StackDetector\LaravelDetector;
use Fortrabbit\StackDetector\StackDetector\StatamicDetector;
use Fortrabbit\StackDetector\StackDetector\SymfonyDetector;
use Fortrabbit\StackDetector\StackDetector\WordpressDetector;
use Fortrabbit\StackDetector\DirectoryCrawler\AdapterInterface;

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
