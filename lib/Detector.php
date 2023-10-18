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
    public function __construct(private array $stackDetectors)
    {
    }

    public static function createForFilesystem(): self
    {
        return self::create(new DirectoryCrawler\FilesystemAdapter());
    }

    public static function createForGithub(Client $client = null): self
    {
        $client = $client ?: new \Github\Client();
        $adapter = new GithubAdapter($client);

        return self::create($adapter);
    }

    public static function create(AdapterInterface $adapter): self
    {
        $composerConfigProvider = new ComposerConfigProvider($adapter);
        $packageVersionProvider = new Composer\PackageVersionProvider($composerConfigProvider);

        return new self([
            new LaravelDetector($packageVersionProvider),
            new SymfonyDetector($packageVersionProvider),
            new CraftCMSDetector($packageVersionProvider),
            new WordpressDetector($adapter),
            new StatamicDetector($packageVersionProvider),
        ]);
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
        foreach ($this->stackDetectors as $stackDetector) {
            $stack = $stackDetector->getStack($baseUri, $subFolder);

            if ($stack !== null) {
                return $stack;
            }
        }

        return null;
    }
}
