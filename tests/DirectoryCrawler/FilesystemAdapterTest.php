<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector\DirectoryCrawler;

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
    public function get_file_content(): void
    {
        $content = $this->sut->getFileContent(__DIR__, 'FilesystemAdapterTest.php');

        $this->assertStringContainsString('class FilesystemAdapterTest extends TestCase', $content);
    }

    /** @test */
    public function it_says_if_a_directory_exists(): void
    {
        $this->assertTrue($this->sut->directoryExists(__DIR__));
    }

    /** @test */
    public function it_says_if_a_directory_does_not_exist(): void
    {
        $this->assertFalse($this->sut->directoryExists(
            __DIR__,
            'non-existing-directory',
            'lorem',
            'ipsum'
        ));
    }

    /** @test */
    public function it_list_files_in_a_directory(): void
    {
        $files = $this->sut->listFilesInDirectory(
            __DIR__,
            '..',
            'fixtures',
            'composer-lock'
        );

        $this->assertSame($files, ['composer.json', 'composer.lock']);
    }
}
