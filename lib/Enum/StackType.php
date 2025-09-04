<?php

declare(strict_types=1);

namespace Fortrabbit\PhpStackDetector\Enum;

enum StackType: string
{
    case BOLT_CMS = 'bolt-cms';
    case CAKE_PHP = 'cakephp';
    case CODEIGNITER = 'codeigniter';
    case CRAFT_CMS = 'craft-cms';
    case DRUPAL = 'drupal';
    case GRAV_CMS = 'grav-cms';
    case LARAVEL = 'laravel';
    case LEAF_PHP = 'leaf';
    case LUNAR = 'lunar';
    case OCTOBER_CMS = 'october-cms';
    case SHOPWARE = 'shopware';
    case STATAMIC = 'statamic';
    case SYMFONY = 'symfony';
    case TEMPEST = 'tempest';
    case TWILL = 'twill';
    case TYPO3_CMS = 'typo3-cms';
    case WINTER_CMS = 'winter-cms';
    case WORDPRESS = 'wordpress';
}
