<?php

namespace Einenlum\PhpStackDetector\StackDetector;

use Einenlum\PhpStackDetector\Stack;
use Einenlum\PhpStackDetector\StackDetectorInterface;
use Einenlum\PhpStackDetector\StackType;

class WordpressDetector implements StackDetectorInterface
{
    public function getStack(string $folderPath): ?Stack
    {
        if (!is_dir($folderPath . '/wp-includes')) {
            return null;
        }

        $versionFile = $folderPath . '/wp-includes/version.php';
        if (is_file($versionFile)) {
            $version = $this->parseFileAndGetVersion($versionFile);

            return new Stack(
                StackType::WORDPRESS,
                $version,
            );
        }

        $varsFile = $folderPath . '/wp-includes/vars.php';
        if (is_file($varsFile)) {
            $version = $this->parseFileAndGetVersion($varsFile);

            return new Stack(
                StackType::WORDPRESS,
                $version,
            );
        }

        return new Stack(
            StackType::WORDPRESS,
            null
        );
    }

    private function parseFileAndGetVersion(string $filePath): ?string
    {
        $fileContent = file_get_contents($filePath);

        if (false === $fileContent) {
            return null;
        }

        foreach (explode("\n", $fileContent) as $line) {
            if (mb_strpos($line, '$wp_version') !== false) {
                if (preg_match('/^\$wp_version\s?=\s?[\'"](.*)[\'"];/', $line, $matches)) {
                    return $matches[1];
                }
            }
        }

        return null;
    }
}
