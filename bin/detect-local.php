<?php

require_once __DIR__.'/../vendor/autoload.php';

use Fortrabbit\StackDetector\Factory\FilesystemDetectorFactory;

$factory = new FilesystemDetectorFactory();
$detector = $factory->create();

$directory = $argv[1] ?? null;
if (null === $directory) {
    echo 'Please provide a directory to scan'."\n";
    exit(1);
}

$subDirectory = $argv[2] ?? null;

$config = $detector->getFullConfiguration($directory, $subDirectory);

$phpConfig = $config->phpConfiguration;
echo 'Detected PHP version: '.($phpConfig->phpVersion?->version ?: 'Unknown version')."\n";
echo 'Detected PHP requirements: '.($phpConfig->phpVersion?->requirements ?: 'Unknown version')."\n";
echo 'Required extensions: '.(empty($phpConfig->requiredExtensions) ? 'None' : implode(', ', $phpConfig->requiredExtensions))."\n";

$stack = $config->stack;

if (null === $stack) {
    echo 'No stack detected'."\n";
    exit(0);
}

echo 'Detected stack: '.$stack->type->value."\n";
echo 'Version: '.($stack->version ?: 'Unknown version')."\n";

$nodeConfig = $config->nodeConfiguration;

echo "\n";
echo 'Detected Node.js version: '.($nodeConfig?->version ?: 'Unknown version')."\n";
echo 'Detected Node.js requirements: '.($nodeConfig?->requirements ?: 'Unknown version')."\n";
echo 'Package Manager: '.($nodeConfig?->packageManager?->value ?: 'Unknown')."\n";
