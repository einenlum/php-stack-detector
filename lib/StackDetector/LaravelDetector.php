<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\StackDetector;

use Fortrabbit\PhpStackDetector\DTO\DependencyTree;
use Fortrabbit\PhpStackDetector\DTO\Stack;
use Fortrabbit\PhpStackDetector\StackDetectorInterface;
use Fortrabbit\PhpStackDetector\Enum\StackType;

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
