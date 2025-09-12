<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO;

readonly class PhpConfiguration
{
    public function __construct(
        public ?PhpVersion $phpVersion,
        /** @var string[] */
        public array $requiredExtensions = [],
        /** @var array<string, mixed>|null */
        public ?array $composerJsonContent = null,
        /** @var array<string, mixed>|null */
        public ?array $composerLockContent = null,
    ) {
    }

    /**
     * This only parses prod dependencies from composer.lock.
     *
     * @return array<string, string>
     */
    public function getExactInstalledDependencies(): array
    {
        if (null === $this->composerLockContent || !isset($this->composerLockContent['packages'])) {
            return [];
        }

        $dependencies = [];
        foreach ($this->composerLockContent['packages'] as $package) {
            if (isset($package['name'], $package['version'])) {
                $dependencies[$package['name']] = $package['version'];
            }
        }

        return $dependencies;
    }
}
