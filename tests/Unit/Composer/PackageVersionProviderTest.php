<?php

declare(strict_types=1);

namespace Fortrabbit\Tests\StackDetector\Unit\Composer;

use Fortrabbit\StackDetector\Composer\ComposerConfigProvider;
use Fortrabbit\StackDetector\Composer\PackageVersionProvider;
use Fortrabbit\StackDetector\DirectoryCrawler\FilesystemAdapter;
use PHPUnit\Framework\TestCase;

class PackageVersionProviderTest extends TestCase
{
    private PackageVersionProvider $sut;

    public function setUp(): void
    {
        $adapter = new FilesystemAdapter();
        $composerConfigProvider = new ComposerConfigProvider($adapter);
        $this->sut = new PackageVersionProvider($composerConfigProvider);
    }

    /** @test */
    public function it_gets_the_version_of_a_package_from_lock(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['symfony/framework-bundle']
        );

        $this->assertSame('6.3.5', $version->getVersion());
    }

    /** @test */
    public function it_gets_the_version_of_the_first_package_from_lock(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['someframework/foo', 'symfony/framework-bundle']
        );

        $this->assertSame('2.4.1', $version->getVersion());

        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['symfony/framework-bundle', 'someframework/foo']
        );

        $this->assertSame('6.3.5', $version->getVersion());
    }

    /** @test */
    public function it_gets_the_version_of_the_first_package_from_json(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['someframework/foo', 'symfony/framework-bundle']
        );

        $this->assertSame('2.4', $version->getVersion());

        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['symfony/framework-bundle', 'someframework/foo']
        );

        $this->assertSame('6.3', $version->getVersion());
    }

    /** @test */
    public function it_gets_the_version_of_a_package_from_json(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['symfony/framework-bundle']
        );

        $this->assertSame('6.3', $version->getVersion());
    }

    /** @test */
    public function it_returns_null_if_package_is_not_found_in_lock(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['lorem/ipsum']
        );

        $this->assertSame(null, $version);
    }

    /** @test */
    public function it_returns_null_if_package_is_not_found_in_json(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['lorem/ipsum']
        );

        $this->assertSame(null, $version);
    }
}
