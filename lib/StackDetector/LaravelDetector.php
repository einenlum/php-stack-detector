<?php

declare(strict_types=1);

namespace fortrabbit\StackDetector\StackDetector;

use fortrabbit\StackDetector\DTO\DependencyTree;
use fortrabbit\StackDetector\DTO\Stack;
use fortrabbit\StackDetector\StackDetectorInterface;
use fortrabbit\StackDetector\Enum\StackType;

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
