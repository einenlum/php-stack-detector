<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\DependencyTree;
use Einenlum\PhpStackDetector\DTO\Stack;
use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

class LaravelDetector extends BaseComposerTypeDetector implements StackDetectorInterface
{
    protected function packagesToSearch(): array
    {
        return ['laravel/framework'];
    }

    protected function detectedStackType(): StackType
    {
        return StackType::LARAVEL;
    }

    public function getStack(string $baseUri, ?string $subDirectory): ?Stack
    {
        foreach (DependencyTree::getChildStacksForPackage('laravel/framework') as $packageName) {
            if (null !== $this->packageVersionProvider->getVersionForPackage(
                $baseUri,
                $subDirectory,
                [$packageName],
            )) {
                return null;
            }
        }

        return parent::getStack($baseUri, $subDirectory);
    }
}
