<?php

declare(strict_types=1);

namespace Einenlum\PhpStackDetector\DirectoryCrawler;

use Einenlum\PhpStackDetector\Exception\ResourceNotFoundException;
use Github\Client;
use Github\Exception\RuntimeException;

readonly class GithubAdapter implements AdapterInterface
{
    /*
     * If you need to check private repositories, the client should already
     * be authenticated.
     */
    public function __construct(private Client $client)
    {
    }

    public function getFileContent(string $baseUri, ?string ...$pathTree): string
    {
        $config = $this->splitBaseUri($baseUri);

        try {
            /** @var array{content: string} $content */
            $content = $this->client->repo()->contents()->show(
                $config['organization'],
                $config['repository'],
                $this->getPathTreeAsString($pathTree),
                $config['reference']
            );
        } catch (RuntimeException) {
            throw ResourceNotFoundException::fromFullUri($baseUri);
        }

        return base64_decode($content['content']);
    }

    public function directoryExists(string $baseUri, ?string ...$pathTree): bool
    {
        $config = $this->splitBaseUri($baseUri);

        if (empty(array_filter($pathTree))) {
            try {
                $this->client->repo()->branches(
                    $config['organization'],
                    $config['repository'],
                );

                return true;
            } catch (RuntimeException $e) {
                return false;
            }
        }

        try {
            /** @var array<int|string, mixed> $content */
            $content = $this->client->repo()->contents()->show(
                $config['organization'],
                $config['repository'],
                $this->getPathTreeAsString($pathTree),
                $config['reference']
            );
        } catch (RuntimeException $e) {
            return false;
        }

        return array_is_list($content);
    }

    public function listFilesInDirectory(string $baseUri, ?string ...$pathTree): array
    {
        $config = $this->splitBaseUri($baseUri);

        try {
            /** @var array<int, array{name: string}> $content */
            $content = $this->client->repo()->contents()->show(
                $config['organization'],
                $config['repository'],
                $this->getPathTreeAsString($pathTree),
                $config['reference']
            );
        } catch (RuntimeException) {
            return [];
        }

        return array_map(
            fn (array $file) => $file['name'],
            $content
        );
    }

    /**
     * @return array{organization: string, repository: string, reference: ?string}
     */
    private function splitBaseUri(string $baseUri): array
    {
        $parts = explode(':', $baseUri);

        $reference = null;
        if (count($parts) > 1) {
            $reference = array_pop($parts);
        }

        $paths = explode('/', $parts[0]);

        return [
            'organization' => $paths[0],
            'repository' => $paths[1],
            'reference' => $reference,
        ];
    }

    /** @param (string|null)[] $pathTree */
    private function getPathTreeAsString(array $pathTree): string
    {
        $paths = array_filter($pathTree);

        return implode('/', $paths);
    }
}
