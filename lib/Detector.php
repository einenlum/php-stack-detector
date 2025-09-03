<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class Detector
{
    /** @param StackDetectorInterface[] $stackDetectors */
    public function __construct(private array $stackDetectors)
    {
    }

    /**
     * @param string $baseUri The base URI of the project, e.g.
     *                        /some/path/to/local/project
     *                        or
     *                        symfony/demo for a remote Github repository
     *                        or
     *                        symfony/demo:v1.1 for a remote Github repository with a reference
     */
    public function getStack(string $baseUri, ?string $subFolder = null): ?Stack
    {
        $subFolder = $this->cleanSubFolder($subFolder);

        foreach ($this->stackDetectors as $stackDetector) {
            $stack = $stackDetector->getStack($baseUri, $subFolder);

            if (null !== $stack) {
                return $stack;
            }
        }

        return null;
    }

    private function cleanSubFolder(?string $subFolder): ?string
    {
        if (null === $subFolder) {
            return null;
        }

        return '/' === trim($subFolder) ? null : $subFolder;
    }
}
