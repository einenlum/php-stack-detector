<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Factory;

use Fortrabbit\PhpStackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\PhpStackDetector\Detector;
use Fortrabbit\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
use Fortrabbit\PhpStackDetector\Node\PackageJsonProvider;
use Fortrabbit\PhpStackDetector\NodeConfigurationDetector;
use Fortrabbit\PhpStackDetector\PhpConfigurationDetector;

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
