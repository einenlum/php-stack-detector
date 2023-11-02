<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector\Composer;

use Einenlum\PhpStackDetector\Composer\ComposerConfig;
use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Composer\ComposerConfigType;
use Einenlum\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
use PHPUnit\Framework\TestCase;


/**
 * Tests composer config provider on filesystem
 */
class ComposerConfigProviderFilesystemTest extends TestCase
{
    private ComposerConfigProvider $sut;

    public function setUp(): void
    {
        $adapter = new FilesystemAdapter();
        $this->sut = new ComposerConfigProvider($adapter);
    }

    /** @test */
    public function it_returns_a_lock_config_if_present(): void
    {
        $config = $this->sut->getComposerConfig(
            __DIR__,
            '../fixtures/composer-lock',
        );

        $this->assertInstanceOf(ComposerConfig::class, $config);
        $this->assertSame(ComposerConfigType::LOCK, $config->type);
        $this->assertIsArray($config->content);
        $this->assertArrayHasKey('_readme', $config->content);
        $this->assertArrayHasKey('content-hash', $config->content);
        $this->assertArrayHasKey('packages', $config->content);
    }

    /** @test */
    public function it_returns_a_json_config_if_no_lock_is_present(): void
    {
        $config = $this->sut->getComposerConfig(
            __DIR__,
            '../fixtures/composer-json',
        );

        $this->assertInstanceOf(ComposerConfig::class, $config);
        $this->assertSame(ComposerConfigType::JSON, $config->type);
        $this->assertIsArray($config->content);
        $this->assertArrayHasKey('type', $config->content);
        $this->assertArrayHasKey('license', $config->content);
        $this->assertArrayHasKey('require', $config->content);
    }
}
