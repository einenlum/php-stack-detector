<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\StackDetector;

use Fortrabbit\StackDetector\DTO\DependencyTree;
use Fortrabbit\StackDetector\DTO\Stack;
use Fortrabbit\StackDetector\StackDetectorInterface;
use Fortrabbit\StackDetector\Enum\StackType;

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
