<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\DirectoryCrawler\GithubAdapter;
use Github\Client;

class GithubDetectorFactory
{
    use HasStackDetectors;

    public function create(Client $client = null): Detector
    {
        $client = $client ?: new \Github\Client();
        $adapter = new GithubAdapter($client);

        $stackDetectors = $this->getStackDetectors($adapter);

        return new Detector($stackDetectors);
    }
}
