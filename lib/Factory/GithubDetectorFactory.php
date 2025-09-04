<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\Factory;

use fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use fortrabbit\StackDetector\Detector;
use fortrabbit\StackDetector\DirectoryCrawler\GithubAdapter;
use fortrabbit\StackDetector\Node\PackageJsonProvider;
use fortrabbit\StackDetector\NodeConfigurationDetector;
use fortrabbit\StackDetector\PhpConfigurationDetector;
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
