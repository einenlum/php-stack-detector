<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\Factory;

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;

class FilesystemDetectorFactory
{
    use HasStackDetectors;

    public function create(): Detector
    {
        $stackDetectors = $this->getStackDetectors(new FilesystemAdapter());

        return new Detector($stackDetectors);
    }
}
