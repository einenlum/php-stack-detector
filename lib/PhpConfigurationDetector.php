<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector;

use fortrabbit\StackDetector\DTO\Composer\ComposerConfig;
use fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use fortrabbit\StackDetector\DTO\Enum\ComposerConfigType;
use fortrabbit\StackDetector\DTO\PhpConfiguration;
use fortrabbit\StackDetector\DTO\PhpVersion;

class PhpConfigurationDetector
{
    public function __construct(private ComposerConfigProvider $composerConfigProvider)
    {
    }

    public function getPhpConfiguration(string $baseUri, ?string $subFolder = null): PhpConfiguration
    {
        $composerJsonConfig = $this->composerConfigProvider->getComposerConfig(
            ComposerConfigType::JSON,
            $baseUri,
            $subFolder
        );

        if (null === $composerJsonConfig) {
            return new PhpConfiguration(null, [], null, null);
        }

        $phpVersion = $this->getPhpVersion($composerJsonConfig);
        $requiredExtensions = $this->getRequiredExtensions($composerJsonConfig);

        $composerLockConfig = $this->composerConfigProvider->getComposerConfig(
            ComposerConfigType::LOCK,
            $baseUri,
            $subFolder
        );

        return new PhpConfiguration(
            $phpVersion,
            $requiredExtensions,
            $composerJsonConfig->content,
            $composerLockConfig?->content
        );
    }

    private function getPhpVersion(ComposerConfig $config): ?PhpVersion
    {
        $content = $config->content;
        if (isset($content['config']['platform']['php'])) {
            $configPlatformVersion = $content['config']['platform']['php'];
        }

        if (isset($content['require']['php'])) {
            $phpVersionRequirements = $content['require']['php'];
        }

        if (!isset($configPlatformVersion) && !isset($phpVersionRequirements)) {
            return null;
        }

        return new PhpVersion(
            $configPlatformVersion ?? null,
            $phpVersionRequirements ?? null
        );
    }

    /** @return string[] */
    private function getRequiredExtensions(ComposerConfig $config): array
    {
        $content = $config->content;
        if (!isset($content['require'])) {
            return [];
        }

        $extensions = [];
        foreach ($content['require'] as $package => $version) {
            if (str_starts_with($package, 'ext-')) {
                $extensions[] = substr($package, 4);
            }
        }

        return $extensions;
    }
}
