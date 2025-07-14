<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/lib')
    ->in(__DIR__ . '/tests/Unit');

$config = new PhpCsFixer\Config();
$config->setUnsupportedPhpVersionAllowed(true);

return $config
    ->setParallelConfig(\PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
    '@Symfony' => true,
    '@PSR1' => true,
    '@PSR2' => true,
    '@PSR12' => true,
])->setFinder($finder);
