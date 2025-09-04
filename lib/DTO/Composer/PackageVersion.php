<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\DTO\Composer;

use Einenlum\ComposerVersionParser\Parser;

readonly class PackageVersion
{
    public function __construct(
        private ?string $requirement,
        private ?string $version,
    ) {
    }

    public function getVersion(): ?string
    {
        if (null !== $this->version) {
            if (0 === mb_strpos($this->version, 'v')) {
                return mb_substr($this->version, 1);
            }

            return $this->version;
        }

        /** @var string $requirement */
        $requirement = $this->requirement;

        if (str_starts_with($requirement, '~v')) {
            $requirement =  mb_substr($requirement, 2);
        }

        return new Parser()->parse($requirement);
    }
}
