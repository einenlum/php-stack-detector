<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
use Einenlum\PhpStackDetector\NodeConfigurationDetector;
use Einenlum\PhpStackDetector\PhpConfigurationDetector;

class FilesystemDetectorFactory
{
    use HasStackDetectors;

    public function create(): Detector
    {
        $adapter = new FilesystemAdapter();
        $composerConfigProvider = new ComposerConfigProvider($adapter);

        $phpConfigurationDetector = new PhpConfigurationDetector($composerConfigProvider);
        $nodeConfigurationDetector = new NodeConfigurationDetector($adapter);
        $stackDetectors = $this->getStackDetectors($composerConfigProvider, $adapter);

        return new Detector(
            $phpConfigurationDetector,
            $nodeConfigurationDetector,
            $stackDetectors
        );
    }
}
