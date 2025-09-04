<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

enum NodePackageManagerType: string
{
    case NPM = 'npm';
    case YARN = 'yarn';
    case YARN_BERRY = 'yarn-berry';
    case PNPM = 'pnpm';
    case BUN = 'bun';
}
