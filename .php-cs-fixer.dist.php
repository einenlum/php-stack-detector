<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/lib')
    ->in(__DIR__.'/tests/Unit');

$config = new PhpCsFixer\Config();
$config->setUnsupportedPhpVersionAllowed(true);

return $config
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        '@PSR12' => true,
        /* Make long php unit tests easier to read */
        'php_unit_method_casing' => ['case' => 'snake_case'],
    ])->setFinder($finder);
