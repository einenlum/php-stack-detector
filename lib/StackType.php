<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector;

enum StackType: string
{
    case LARAVEL = 'laravel';
    case SYMFONY = 'symfony';
    case CRAFT_CMS = 'craft-cms';
    case STATAMIC = 'statamic';
    case WORDPRESS = 'wordpress';
    case LEAF_PHP = 'leaf';
    case SHOPWARE = 'shopware';
    case OCTOBER_CMS = 'october-cms';
    case TEMPEST = 'tempest';
    case BOLT_CMS = 'bolt-cms';
    case DRUPAL = 'drupal';
    case LUNAR = 'lunar';
    case TWILL = 'twill';
    case WINTER_CMS = 'winter-cms';
    case TYPO3_CMS = 'typo3-cms';
    case CAKE_PHP = 'cakephp';
    case GRAV_CMS = 'grav-cms';
    case CODEIGNITER = 'codeigniter';
}
