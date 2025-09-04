<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\Factory;

use Fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\StackDetector\Detector;
use Fortrabbit\StackDetector\DirectoryCrawler\GithubAdapter;
use Fortrabbit\StackDetector\Node\PackageJsonProvider;
use Fortrabbit\StackDetector\NodeConfigurationDetector;
use Fortrabbit\StackDetector\PhpConfigurationDetector;
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
