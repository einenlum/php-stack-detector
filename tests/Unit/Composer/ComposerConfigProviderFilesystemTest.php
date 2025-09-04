<?php

declare(strict_types=1);

namespace Fortrabbit\Tests\PhpStackDetector\Unit\Composer;

use Fortrabbit\PhpStackDetector\DTO\Composer\ComposerConfig;
use Fortrabbit\PhpStackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\PhpStackDetector\DTO\Enum\ComposerConfigType;
use Fortrabbit\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
use PHPUnit\Framework\TestCase;

/**
 * Tests composer config provider on filesystem.
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
            ComposerConfigType::LOCK,
            __DIR__,
            '../../fixtures/composer-config/composer-lock',
        );

        $this->assertInstanceOf(ComposerConfig::class, $config);
        $this->assertSame(ComposerConfigType::LOCK, $config->type);
        $this->assertIsArray($config->content);
        $this->assertArrayHasKey('_readme', $config->content);
        $this->assertArrayHasKey('content-hash', $config->content);
        $this->assertArrayHasKey('packages', $config->content);
    }

    /** @test */
    public function it_returns_null_if_no_lock_config_if_present(): void
    {
        $config = $this->sut->getComposerConfig(
            ComposerConfigType::LOCK,
            __DIR__,
            '../../fixtures/composer-config/composer-json',
        );

        $this->assertNull($config);
    }

    /** @test */
    public function it_returns_a_json_config_if_present(): void
    {
        $config = $this->sut->getComposerConfig(
            ComposerConfigType::JSON,
            __DIR__,
            '../../fixtures/composer-config/composer-json',
        );

        $this->assertInstanceOf(ComposerConfig::class, $config);
        $this->assertSame(ComposerConfigType::JSON, $config->type);
        $this->assertIsArray($config->content);
        $this->assertArrayHasKey('type', $config->content);
        $this->assertArrayHasKey('license', $config->content);
        $this->assertArrayHasKey('require', $config->content);
    }

    /** @test */
    public function it_returns_null_if_no_json_config_if_present(): void
    {
        $config = $this->sut->getComposerConfig(
            ComposerConfigType::JSON,
            __DIR__,
            '../../fixtures/composer-config/composer-lock',
        );

        $this->assertNull($config);
    }
}
