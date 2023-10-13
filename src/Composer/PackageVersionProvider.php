<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\ComposerVersionParser\Parser;

class PackageVersionProvider
{
    /**
     * @param string ...$packageNames A list of packages to check in that order
     */
    public function getVersionForPackage(
        string $folderPath,
        string ...$packageNames
    ): ?PackageVersion {
        $lock = $this->getComposerLockConfig($folderPath);
        if (null !== $lock) {
            foreach ($packageNames as $packageName) {
                foreach ($lock['packages'] as $package) {
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

        $config = $this->getComposerConfig($folderPath);
        if (null === $config) {
            return null;
        }

        foreach ($packageNames as $name) {
            foreach ($config['require'] as $packageName => $requirement) {
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

    /** @return null|array<string, mixed> */
    private function getComposerConfig(string $folderPath): ?array
    {
        return $this->getFile($folderPath, 'composer.json');
    }

    /** @return null|array<string, mixed> */
    private function getComposerLockConfig(string $folderPath): ?array
    {
        return $this->getFile($folderPath, 'composer.lock');
    }

    /** @return array<string, mixed>|null */
    private function getFile(string $folderPath, string $filename): ?array
    {
        if (!is_dir($folderPath)) {
            return null;
        }

        $path = $folderPath . '/' . $filename;
        if (!is_file($path)) {
            return null;
        }

        /** @var string $content */
        $content = file_get_contents($path);

        try {
            /** @var array<string, mixed> $composerConfig */
            $composerConfig = json_decode(
                $content,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException) {
            return null;
        }

        return $composerConfig;
    }
}
