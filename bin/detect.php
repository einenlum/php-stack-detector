<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Einenlum\PhpStackDetector\Detector;

$detector = Detector::create();

$directory = $argv[1] ?? null;
if (null === $directory || !is_dir($directory)) {
    echo 'Please provide a directory to scan' . "\n";
    exit(1);
}

$stack = $detector->getStack($directory);

if (null === $stack) {
    echo 'No stack detected' . "\n";
    exit(0);
}

echo 'Detected stack: ' . $stack->type->value . "\n";
echo 'Version: ' . ($stack->version ?: 'Unknown version') . "\n";
