<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\Factory;

use fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use fortrabbit\StackDetector\Composer\PackageVersionProvider;
use fortrabbit\StackDetector\StackDetector\BoltCMSDetector;
use fortrabbit\StackDetector\StackDetector\CakePhpDetector;
use fortrabbit\StackDetector\StackDetector\CodeigniterDetector;
use fortrabbit\StackDetector\StackDetector\DrupalDetector;
use fortrabbit\StackDetector\StackDetector\GravCMSDetector;
use fortrabbit\StackDetector\StackDetector\LeafDetector;
use fortrabbit\StackDetector\StackDetector\LunarDetector;
use fortrabbit\StackDetector\StackDetector\OctoberCMSDetector;
use fortrabbit\StackDetector\StackDetector\ShopwareDetector;
use fortrabbit\StackDetector\StackDetector\TempestDetector;
use fortrabbit\StackDetector\StackDetector\TwillDetector;
use fortrabbit\StackDetector\StackDetector\Typo3Detector;
use fortrabbit\StackDetector\StackDetector\WinterCMSDetector;
use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\StackDetector\CraftCMSDetector;
use fortrabbit\StackDetector\StackDetector\LaravelDetector;
use fortrabbit\StackDetector\StackDetector\StatamicDetector;
use fortrabbit\StackDetector\StackDetector\SymfonyDetector;
use fortrabbit\StackDetector\StackDetector\WordpressDetector;
use fortrabbit\StackDetector\DirectoryCrawler\AdapterInterface;

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
