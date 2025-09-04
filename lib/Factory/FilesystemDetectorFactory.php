<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\Factory;

use Fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\StackDetector\Detector;
use Fortrabbit\StackDetector\DirectoryCrawler\FilesystemAdapter;
use Fortrabbit\StackDetector\Node\PackageJsonProvider;
use Fortrabbit\StackDetector\NodeConfigurationDetector;
use Fortrabbit\StackDetector\PhpConfigurationDetector;

class FilesystemDetectorFactory
{
    use HasStackDetectors;

    public function create(): Detector
    {
        $adapter = new FilesystemAdapter();
        $composerConfigProvider = new ComposerConfigProvider($adapter);

        $phpConfigurationDetector = new PhpConfigurationDetector($composerConfigProvider);

        $packageJsonProvider = new PackageJsonProvider($adapter);
        $nodeConfigurationDetector = new NodeConfigurationDetector(
            $packageJsonProvider,
            $adapter
        );
        $stackDetectors = $this->getStackDetectors($composerConfigProvider, $adapter);

        return new Detector(
            $phpConfigurationDetector,
            $nodeConfigurationDetector,
            $stackDetectors
        );
    }
}
