<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\Factory\GithubDetectorFactory;
use Github\AuthMethod;

$factory = new GithubDetectorFactory();

$accessToken = getenv('GITHUB_ACCESS_TOKEN');
if ($accessToken) {
    $client = new \Github\Client();
    $client->authenticate($accessToken, null, AuthMethod::ACCESS_TOKEN);
    $detector = $factory->create($client);
} else {
    $detector = $factory->create();
}

$directory = $argv[1] ?? null;
if (null === $directory) {
    echo 'Please provide a directory to scan' . "\n";
    exit(1);
}

$subDirectory = $argv[2] ?? null;

$stack = $detector->getStack($directory, $subDirectory);

if (null === $stack) {
    echo 'No stack detected' . "\n";
    exit(0);
}

echo 'Detected stack: ' . $stack->type->value . "\n";
echo 'Version: ' . ($stack->version ?: 'Unknown version') . "\n";
