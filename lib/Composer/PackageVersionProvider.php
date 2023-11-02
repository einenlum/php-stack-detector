<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\PhpStackDetector\DirectoryCrawler\AdapterInterface;

class PackageVersionProvider
{
    public function __construct(private ComposerConfigProvider $configProvider)
    {
    }

    /**
     * @param string ...$packageNames A list of packages to check in that order
     */
    public function getVersionForPackage(
        string $baseUri,
        ?string $subDirectory,
        string ...$packageNames
    ): ?PackageVersion {
        $config = $this->configProvider->getComposerConfig($baseUri, $subDirectory);
        if (null === $config) {
            return null;
        }

        if ($config->type === ComposerConfigType::LOCK) {
            foreach ($packageNames as $packageName) {
                foreach ($config->content['packages'] as $package) {
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
