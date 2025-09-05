<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector;

use fortrabbit\StackDetector\DTO\NodeConfiguration;
use fortrabbit\StackDetector\DirectoryCrawler\AdapterInterface;
use fortrabbit\StackDetector\Enum\NodePackageManagerType;
use fortrabbit\StackDetector\Exception\ResourceNotFoundException;
use fortrabbit\StackDetector\Node\PackageJsonProvider;

class NodeConfigurationDetector
{
    public function __construct(
        private PackageJsonProvider $packageJsonProvider,
        private AdapterInterface $adapter,
    ) {
    }

    public function getNodeConfiguration(
        string $baseUri,
        ?string $subFolder = null,
    ): ?NodeConfiguration {
        $packageJsonConfig = $this->packageJsonProvider->getPackageJsonConfig(
            $baseUri,
            $subFolder,
        );
        if (null === $packageJsonConfig) {
            return null;
        }

        return new NodeConfiguration(
            $this->getNodeVersion($baseUri, $subFolder),
            $this->getVersionRequirements($baseUri, $subFolder),
            $this->getPackageManagerType($baseUri, $subFolder),
            $packageJsonConfig,
        );
    }

    private function getNodeVersion(string $baseUri, ?string $subFolder = null): ?string
    {
        if (!$this->adapter->directoryExists($baseUri, $subFolder)) {
            return null;
        }

        $nvmrcContent = $this->getFileContent(
            $baseUri,
            $subFolder,
            '.nvmrc'
        );
        $nodeVersion = $this->extractNodeVersion($nvmrcContent);

        if (null !== $nodeVersion) {
            return $nodeVersion;
        }

        $nodeVersionContent = $this->getFileContent(
            $baseUri,
            $subFolder,
            '.node-version'
        );
        $nodeVersion = $this->extractNodeVersion($nodeVersionContent);

        return $nodeVersion;
    }

    private function getVersionRequirements(string $baseUri, ?string $subFolder = null): ?string
    {
        /** @var array<array, mixed> $packageJsonContent */
        $packageJsonContent = $this->packageJsonProvider->getPackageJsonConfig(
            $baseUri,
            $subFolder,
        );

        return $packageJsonContent['engines']['node'] ?? null;
    }

    private function extractNodeVersion(?string $content): ?string
    {
        if (null === $content) {
            return null;
        }

        $lines = explode("\n", trim($content));
        $lines = array_filter(
            $lines,
            fn ($line) => '' !== $line && false === str_starts_with($line, '#')
        );

        $firstLine = $lines[0] ?? null;

        if (null === $firstLine) {
            return null;
        }

        $version = ltrim($firstLine, 'v');

        return $version ?: null;
    }

    private function getPackageManagerType(
        string $baseUri,
        ?string $subFolder = null,
    ): NodePackageManagerType {
        $lockFiles = [
            'package-lock.json' => NodePackageManagerType::NPM,
            'pnpm-lock.yaml' => NodePackageManagerType::PNPM,
            'bun.lock' => NodePackageManagerType::BUN,
        ];

        foreach ($lockFiles as $filename => $type) {
            if ($this->adapter->fileExists($baseUri, $subFolder, $filename)) {
                return $type;
            }
        }

        $yarnType = $this->detectYarn($baseUri, $subFolder);
        if (null !== $yarnType) {
            return $yarnType;
        }

        /** @var array<array, mixed> $packageJsonContent */
        $packageJsonContent = $this->packageJsonProvider->getPackageJsonConfig(
            $baseUri,
            $subFolder,
        );

        $packageManager = $packageJsonContent['packageManager'] ?? null;
        if (null !== $packageManager) {
            $packageManagerParts = explode('@', $packageManager);
            $managerName = $packageManagerParts[0];

            $managerType = NodePackageManagerType::tryFrom($managerName);

            if (null !== $managerType) {
                return $managerType;
            }
        }

        return NodePackageManagerType::NPM; // Default to NPM if no lock file or packageManager field is found
    }

    private function detectYarn(
        string $baseUri,
        ?string $subFolder = null,
    ): ?NodePackageManagerType {
        if (!$this->adapter->fileExists($baseUri, $subFolder, 'yarn.lock')) {
            return null;
        }

        if ($this->adapter->fileExists($baseUri, $subFolder, '.yarnrc.yml')) {
            return NodePackageManagerType::YARN_BERRY;
        }

        return NodePackageManagerType::YARN;
    }

    private function getFileContent(string $baseUri, ?string $subFolder, string $filename): ?string
    {
        try {
            return $this->adapter->getFileContent(
                $baseUri,
                $subFolder,
                $filename
            );
        } catch (ResourceNotFoundException) {
            return null;
        }
    }
}
