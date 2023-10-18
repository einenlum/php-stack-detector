<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;
use Einenlum\PhpStackDetector\StackDetector\CraftCMSDetector;
use Einenlum\PhpStackDetector\StackDetector\LaravelDetector;
use Einenlum\PhpStackDetector\StackDetector\StatamicDetector;
use Einenlum\PhpStackDetector\StackDetector\SymfonyDetector;
use Einenlum\PhpStackDetector\StackDetector\WordpressDetector;

class Detector
{
    /** @param StackDetectorInterface[] $stackDetectors */
    public function __construct(private array $stackDetectors)
    {
    }

    public static function create(AdapterInterface $adapter): self
    {
        $composerConfigProvider = new ComposerConfigProvider($adapter);
        $packageVersionProvider = new Composer\PackageVersionProvider($composerConfigProvider);

        return new self([
            // Statamic uses laravel so it must be checked before
            new StatamicDetector($packageVersionProvider),
            new LaravelDetector($packageVersionProvider),
            new SymfonyDetector($packageVersionProvider),
            new CraftCMSDetector($packageVersionProvider),
            new WordpressDetector($adapter),
        ]);
    }

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
