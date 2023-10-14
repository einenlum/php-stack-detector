<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

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

    public static function create(): self
    {
        $packageVersionProvider = new Composer\PackageVersionProvider();

        return new self([
            // Statamic uses laravel so it must be checked before
            new StatamicDetector($packageVersionProvider),
            new LaravelDetector($packageVersionProvider),
            new SymfonyDetector($packageVersionProvider),
            new CraftCMSDetector($packageVersionProvider),
            new WordpressDetector(),
        ]);
    }

    public function getStack(string $folderPath): ?Stack
    {
        foreach ($this->stackDetectors as $stackDetector) {
            $stack = $stackDetector->getStack($folderPath);

            if ($stack !== null) {
                return $stack;
            }
        }

        return null;
    }
}
