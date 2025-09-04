<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Factory;

use Fortrabbit\PhpStackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\PhpStackDetector\Composer\PackageVersionProvider;
use Fortrabbit\PhpStackDetector\StackDetector\BoltCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetector\CakePhpDetector;
use Fortrabbit\PhpStackDetector\StackDetector\CodeigniterDetector;
use Fortrabbit\PhpStackDetector\StackDetector\DrupalDetector;
use Fortrabbit\PhpStackDetector\StackDetector\GravCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetector\LeafDetector;
use Fortrabbit\PhpStackDetector\StackDetector\LunarDetector;
use Fortrabbit\PhpStackDetector\StackDetector\OctoberCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetector\ShopwareDetector;
use Fortrabbit\PhpStackDetector\StackDetector\TempestDetector;
use Fortrabbit\PhpStackDetector\StackDetector\TwillDetector;
use Fortrabbit\PhpStackDetector\StackDetector\Typo3Detector;
use Fortrabbit\PhpStackDetector\StackDetector\WinterCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\StackDetector\CraftCMSDetector;
use Fortrabbit\PhpStackDetector\StackDetector\LaravelDetector;
use Fortrabbit\PhpStackDetector\StackDetector\StatamicDetector;
use Fortrabbit\PhpStackDetector\StackDetector\SymfonyDetector;
use Fortrabbit\PhpStackDetector\StackDetector\WordpressDetector;
use Fortrabbit\PhpStackDetector\DirectoryCrawler\AdapterInterface;

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
