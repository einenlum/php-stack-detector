<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector;

use Fortrabbit\PhpStackDetector\DTO\Composer\ComposerConfig;
use Fortrabbit\PhpStackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\PhpStackDetector\DTO\Enum\ComposerConfigType;
use Fortrabbit\PhpStackDetector\DTO\PhpConfiguration;
use Fortrabbit\PhpStackDetector\DTO\PhpVersion;

class PhpConfigurationDetector
{
    public function __construct(private ComposerConfigProvider $composerConfigProvider)
    {
    }

    public function getPhpConfiguration(string $baseUri, ?string $subFolder = null): PhpConfiguration
    {
        $composerConfig = $this->composerConfigProvider->getComposerConfig(
            ComposerConfigType::JSON,
            $baseUri,
            $subFolder
        );

        if (null === $composerConfig) {
            return new PhpConfiguration(null, []);
        }

        $phpVersion = $this->getPhpVersion($composerConfig);
        $requiredExtensions = $this->getRequiredExtensions($composerConfig);

        return new PhpConfiguration($phpVersion, $requiredExtensions);
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
