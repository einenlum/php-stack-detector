<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector\Unit\DirectoryCrawler;

use Einenlum\PhpStackDetector\DirectoryCrawler\FilesystemAdapter;
use PHPUnit\Framework\TestCase;

class FilesystemAdapterTest extends TestCase
{
    private FilesystemAdapter $sut;

    public function setUp(): void
    {
        $this->sut = new FilesystemAdapter();
    }

    /** @test */
    public function getFileContent(): void
    {
        $content = $this->sut->getFileContent(__DIR__, 'FilesystemAdapterTest.php');

        $this->assertStringContainsString('class FilesystemAdapterTest extends TestCase', $content);
    }

    /** @test */
    public function itSaysIfADirectoryExists(): void
    {
        $this->assertTrue($this->sut->directoryExists(__DIR__));
    }

    /** @test */
    public function itSaysIfADirectoryDoesNotExist(): void
    {
        $this->assertFalse($this->sut->directoryExists(
            __DIR__,
            'non-existing-directory',
            'lorem',
            'ipsum'
        ));
    }

    /** @test */
    public function itListFilesInADirectory(): void
    {
        $files = $this->sut->listFilesInDirectory(
            __DIR__,
            '../..',
            'fixtures',
            'composer-lock'
        );

        $this->assertSame($files, ['composer.json', 'composer.lock']);
    }
}
