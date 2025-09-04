<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\PhpStackDetector\DTO\Composer\PackageVersion;
use Einenlum\PhpStackDetector\DTO\Enum\ComposerConfigType;

readonly class PackageVersionProvider
{
    public function __construct(private ComposerConfigProvider $configProvider)
    {
    }

    /**
     * @param string[] $packageNames A list of packages to check in that order
     */
    public function getVersionForPackage(
        string $baseUri,
        ?string $subDirectory,
        array $packageNames,
    ): ?PackageVersion {
        $lock = $this->configProvider->getComposerConfig(
            ComposerConfigType::LOCK,
            $baseUri,
            $subDirectory
        );

        if ($lock) {
            foreach ($packageNames as $packageName) {
                foreach ($lock->content['packages'] as $package) {
                    if ($package['name'] === $packageName) {
                        return new PackageVersion(
                            null,
                            $package['version']
                        );
                    }
                }
            }

            return null;
        }

        $config = $this->configProvider->getComposerConfig(
            ComposerConfigType::JSON,
            $baseUri,
            $subDirectory
        );

        if (null === $config || !isset($config->content['require'])) {
            return null;
        }

        foreach ($packageNames as $name) {
            foreach ($config->content['require'] as $packageName => $requirement) {
                if ($packageName === $name) {
                    return new PackageVersion(
                        $requirement,
                        null,
                    );
                }
            }
        }

        return null;
    }
}
