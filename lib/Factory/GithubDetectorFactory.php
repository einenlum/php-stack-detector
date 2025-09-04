<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Factory;

use Fortrabbit\PhpStackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\PhpStackDetector\Detector;
use Fortrabbit\PhpStackDetector\DirectoryCrawler\GithubAdapter;
use Fortrabbit\PhpStackDetector\Node\PackageJsonProvider;
use Fortrabbit\PhpStackDetector\NodeConfigurationDetector;
use Fortrabbit\PhpStackDetector\PhpConfigurationDetector;
use Github\Client;

class GithubDetectorFactory
{
    use HasStackDetectors;

    public function create(?Client $client = null): Detector
    {
        $client = $client ?: new Client();
        $adapter = new GithubAdapter($client);
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
