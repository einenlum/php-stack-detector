<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Composer;

use Einenlum\ComposerVersionParser\Parser;

class PackageVersion
{
    public function __construct(
        private readonly ?string $requirement,
        private readonly ?string $version
    ) {
    }

    public function getVersion(): ?string
    {
        if ($this->version !== null) {
            if (mb_strpos($this->version, 'v') === 0) {
                return mb_substr($this->version, 1);
            }

            return $this->version;
        }

        /** @var string $requirement */
        $requirement = $this->requirement;
        $parser = new Parser();

        return $parser->parse($requirement);
    }
}
