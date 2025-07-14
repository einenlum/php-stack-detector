<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector\Unit\Composer;

use Einenlum\PhpStackDetector\Composer\ComposerConfigProvider;
use Einenlum\PhpStackDetector\Composer\PackageVersionProvider;
use Einenlum\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
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
    public function itGetsTheVersionOfAPackageFromLock(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['symfony/framework-bundle']
        );

        $this->assertSame('6.3.5', $version->getVersion());
    }

    /** @test */
    public function itGetsTheVersionOfTheFirstPackageFromLock(): void
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
    public function itGetsTheVersionOfTheFirstPackageFromJson(): void
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
    public function itGetsTheVersionOfAPackageFromJson(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['symfony/framework-bundle']
        );

        $this->assertSame('6.3', $version->getVersion());
    }

    /** @test */
    public function itReturnsNullIfPackageIsNotFoundInLock(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-lock',
            ['lorem/ipsum']
        );

        $this->assertSame(null, $version);
    }

    /** @test */
    public function itReturnsNullIfPackageIsNotFoundInJson(): void
    {
        $version = $this->sut->getVersionForPackage(
            __DIR__,
            '/../../fixtures/composer-json',
            ['lorem/ipsum']
        );

        $this->assertSame(null, $version);
    }
}
