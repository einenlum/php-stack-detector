<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\Factory;

use fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use fortrabbit\StackDetector\Detector;
use fortrabbit\StackDetector\DirectoryCrawler\FilesystemAdapter;
use fortrabbit\StackDetector\Node\PackageJsonProvider;
use fortrabbit\StackDetector\NodeConfigurationDetector;
use fortrabbit\StackDetector\PhpConfigurationDetector;

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
