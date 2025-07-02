<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Einenlum\PhpStackDetector\DirectoryCrawler\GithubAdapter;
use Einenlum\PhpStackDetector\StackDetector\CraftCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\LaravelDetector;
use Einenlum\PhpStackDetector\StackDetector\StatamicDetector;
use Einenlum\PhpStackDetector\StackDetector\SymfonyDetector;
use Einenlum\PhpStackDetector\StackDetector\WordpressDetector;
use Github\Client;

class Detector
{
    /** @param StackDetectorInterface[] $stackDetectors */
    public function __construct(private readonly array $stackDetectors)
    {
    }

    /**
     * @param string $baseUri The base URI of the project, e.g.
     *     /some/path/to/local/project
     *     or
     *     symfony/demo for a remote Github repository
     *     or
     *     symfony/demo:v1.1 for a remote Github repository with a reference
     */
    public function getStack(string $baseUri, ?string $subFolder = null): ?Stack
    {
        $subFolder = $this->cleanSubFolder($subFolder);

        foreach ($this->stackDetectors as $stackDetector) {
            $stack = $stackDetector->getStack($baseUri, $subFolder);

            if ($stack !== null) {
                return $stack;
            }
        }

        return null;
    }

    private function cleanSubFolder(?string $subFolder): ?string
    {
        if ($subFolder === null) {
            return null;
        }

        return trim($subFolder) === '/' ? null : $subFolder;
    }
}
