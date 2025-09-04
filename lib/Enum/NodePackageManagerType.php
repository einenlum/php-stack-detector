<?php

declare(strict_types=1);

namespace Fortrabbit\StackDetector\Enum;

enum NodePackageManagerType: string
{
    case NPM = 'npm';
    case YARN = 'yarn';
    case YARN_BERRY = 'yarn-berry';
    case PNPM = 'pnpm';
    case BUN = 'bun';
}
