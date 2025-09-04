<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\DirectoryCrawler\GithubAdapter;
use Einenlum\PhpStackDetector\NodeConfigurationDetector;
use Einenlum\PhpStackDetector\PhpConfigurationDetector;
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
        $nodeConfigurationDetector = new NodeConfigurationDetector($adapter);

        $stackDetectors = $this->getStackDetectors($composerConfigProvider, $adapter);

        return new Detector(
            $phpConfigurationDetector,
            $nodeConfigurationDetector,
            $stackDetectors
        );
    }
}
