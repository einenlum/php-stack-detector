<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector;

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\Factory\FilesystemDetectorFactory;
use Einenlum\PhpStackDetector\StackType;
use PHPUnit\Framework\TestCase;

class DetectorTest extends TestCase
{
    private Detector $sut;

    public function setUp(): void
    {
        $factory = new FilesystemDetectorFactory();
        $this->sut = $factory->create();
    }

    /** 
     * @test 
     * @dataProvider symfonyFolders
     */
    public function it_detects_symfony_stack(string $symfonyFolder, ?string $expectedVersion): void
    {
        $stack = $this->sut->getStack(sprintf('%s/fixtures/%s', __DIR__, $symfonyFolder));

        $this->assertNotNull($stack);
        $this->assertSame(StackType::SYMFONY, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    /** 
     * @test 
     * @dataProvider laravelFolders
     */
    public function it_detects_laravel_stack(string $laravelFolder, ?string $expectedVersion): void
    {
        $stack = $this->sut->getStack(sprintf('%s/fixtures/%s', __DIR__, $laravelFolder));

        $this->assertNotNull($stack);
        $this->assertSame(StackType::LARAVEL, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    /** 
     * @test 
     * @dataProvider craftCMSFolders
     */
    public function it_detects_craft_cms_stack(string $craftCMSFolder, ?string $expectedVersion): void
    {
        $stack = $this->sut->getStack(sprintf('%s/fixtures/%s', __DIR__, $craftCMSFolder));

        $this->assertNotNull($stack);
        $this->assertSame(StackType::CRAFT_CMS, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    /** 
     * @test 
     * @dataProvider statamicFolders
     */
    public function it_detects_statamic_stack(string $statamicFolder, ?string $expectedVersion): void
    {
        $stack = $this->sut->getStack(sprintf('%s/fixtures/%s', __DIR__, $statamicFolder));

        $this->assertNotNull($stack);
        $this->assertSame(StackType::STATAMIC, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    /** 
     * @test 
     * @dataProvider wordpressFolders
     */
    public function it_detects_wordpress_stack(string $wordpressFolder, ?string $expectedVersion): void
    {
        $stack = $this->sut->getStack(sprintf('%s/fixtures/%s', __DIR__, $wordpressFolder));

        $this->assertNotNull($stack);
        $this->assertSame(StackType::WORDPRESS, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    public static function symfonyFolders(): array
    {
        return [
            'Symfony 2' => ['symfony/2', '2.3'],
            'Symfony 3' => ['symfony/3', '3.4'],
            'Symfony 4' => ['symfony/4', '4'],
            'Symfony 5' => ['symfony/5', '5.0'],
            'Symfony 6' => ['symfony/6', '6.3'],
            'Symfony unknown version' => ['symfony/unknown', null],
        ];
    }

    public static function laravelFolders(): array
    {
        return [
            'Laravel 5' => ['laravel/5', '5.2'],
            'Laravel 6' => ['laravel/6', '6'],
            'Laravel 7' => ['laravel/7', '7'],
            'Laravel 8' => ['laravel/8', '8'],
            'Laravel 9' => ['laravel/9', '9'],
            'Laravel 10' => ['laravel/10', '10'],
            'Laravel unknown version' => ['laravel/unknown', null],
        ];
    }

    public static function wordpressFolders(): array
    {
        return [
            'Wordpress 1' => ['wordpress/1', '1.0.2'],
            'Wordpress 2' => ['wordpress/2', '2.0.11'],
            'Wordpress 3' => ['wordpress/3', '3.0.6'],
            'Wordpress 4' => ['wordpress/4', '4.0.38'],
            'Wordpress 5' => ['wordpress/5', '5.0.20'],
            'Wordpress 6' => ['wordpress/6', '6.3.2'],
        ];
    }

    public static function craftCMSFolders(): array
    {
        return [
            'Craft CMS 3' => ['craft_cms/3', '3.6'],
            'Craft CMS 4' => ['craft_cms/4', '4.4'],
            'Craft CMS unknown version' => ['craft_cms/unknown', null],
        ];
    }

    public static function statamicFolders(): array
    {
        return [
            'Statamic 4' => ['statamic/4', '4'],
            'Statamic unknown version' => ['statamic/unknown', null],
        ];
    }
}
