<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

readonly class Detector
{
    /** @param StackDetectorInterface[] $stackDetectors */
    public function __construct(
        private PhpConfigurationDetector $phpConfigurationDetector,
        private NodeConfigurationDetector $nodeConfigurationDetector,
        private array $stackDetectors,
    ) {
    }

    public function getFullConfiguration(string $baseUri, ?string $subFolder = null): FullConfiguration
    {
        $subFolder = $this->cleanSubFolder($subFolder);

        $phpConfiguration = $this->getPhpConfiguration($baseUri, $subFolder);
        $nodeConfiguration = $this->getNodeConfiguration($baseUri, $subFolder);
        $stack = $this->getStack($baseUri, $subFolder);

        return new FullConfiguration(
            $phpConfiguration,
            $nodeConfiguration,
            $stack,
        );
    }

    private function getPhpConfiguration(string $baseUri, ?string $subFolder = null): PhpConfiguration
    {
        return $this->phpConfigurationDetector->getPhpConfiguration($baseUri, $subFolder);
    }

    private function getNodeConfiguration(string $baseUri, ?string $subFolder = null): ?NodeConfiguration
    {
        return $this->nodeConfigurationDetector->getNodeConfiguration($baseUri, $subFolder);
    }

    /**
     * @param string $baseUri The base URI of the project, e.g.
     *                        /some/path/to/local/project
     *                        or
     *                        symfony/demo for a remote Github repository
     *                        or
     *                        symfony/demo:v1.1 for a remote Github repository with a reference
     */
    private function getStack(string $baseUri, ?string $subFolder = null): ?Stack
    {
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
