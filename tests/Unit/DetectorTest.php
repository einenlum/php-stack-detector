<?php

declare(strict_types=1);

namespace Einenlum\Tests\PhpStackDetector\Unit;

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
     *
     * @dataProvider packagesDataProvider
     */
    public function itDetectsStack(string $fixtureFolder, ?string $expectedVersion, StackType $expectedType): void
    {
        $stack = $this->sut->getStack(sprintf('%s/../fixtures/%s', __DIR__, $fixtureFolder));

        $this->assertNotNull($stack);
        $this->assertSame($expectedType, $stack->type);
        $this->assertSame($expectedVersion, $stack->version);
    }

    public static function packagesDataProvider(): array
    {
        return [
            'Symfony 2' => ['symfony/2', '2.3', StackType::SYMFONY],
            'Symfony 3' => ['symfony/3', '3.4', StackType::SYMFONY],
            'Symfony 4' => ['symfony/4', '4', StackType::SYMFONY],
            'Symfony 5' => ['symfony/5', '5.0', StackType::SYMFONY],
            'Symfony 6' => ['symfony/6', '6.3', StackType::SYMFONY],
            'Symfony unknown version' => ['symfony/unknown', null, StackType::SYMFONY],

            'Laravel 5' => ['laravel/5', '5.2', StackType::LARAVEL],
            'Laravel 6' => ['laravel/6', '6', StackType::LARAVEL],
            'Laravel 7' => ['laravel/7', '7', StackType::LARAVEL],
            'Laravel 8' => ['laravel/8', '8', StackType::LARAVEL],
            'Laravel 9' => ['laravel/9', '9', StackType::LARAVEL],
            'Laravel 10' => ['laravel/10', '10', StackType::LARAVEL],
            'Laravel unknown version' => ['laravel/unknown', null, StackType::LARAVEL],

            'Bolt CMS 5' => ['bolt_cms/5', '5', StackType::BOLT_CMS],

            'Cake PHP 5' => ['cakephp/5', '5.1', StackType::CAKE_PHP],

            'Codeigniter 4' => ['codeigniter/4', '4', StackType::CODEIGNITER],

            'Drupal 11' => ['drupal/11', '11', StackType::DRUPAL],

            'Grav CMS 2' => ['grav_cms/2', '2', StackType::GRAV_CMS],

            'Leaf 3' => ['leaf/3', '3', StackType::LEAF_PHP],

            'Lunar 1' => ['lunar/1', '1', StackType::LUNAR],

            'October CMS 4' => ['october_cms/4', '4', StackType::OCTOBER_CMS],

            'Shopware 6' => ['shopware/6', '6.7.0', StackType::SHOPWARE],

            'Twill 3' => ['twill/3', '3', StackType::TWILL],

            'Typo 3 13' => ['typo3_cms/13', '13', StackType::TYPO3_CMS],

            'Winter CMS 1' => ['winter_cms/1', '1.2', StackType::WINTER_CMS],

            'Wordpress 1' => ['wordpress/1', '1.0.2', StackType::WORDPRESS],
            'Wordpress 2' => ['wordpress/2', '2.0.11', StackType::WORDPRESS],
            'Wordpress 3' => ['wordpress/3', '3.0.6', StackType::WORDPRESS],
            'Wordpress 4' => ['wordpress/4', '4.0.38', StackType::WORDPRESS],
            'Wordpress 5' => ['wordpress/5', '5.0.20', StackType::WORDPRESS],
            'Wordpress 6' => ['wordpress/6', '6.3.2', StackType::WORDPRESS],

            'Craft CMS 3' => ['craft_cms/3', '3.6', StackType::CRAFT_CMS],
            'Craft CMS 4' => ['craft_cms/4', '4.4', StackType::CRAFT_CMS],
            'Craft CMS unknown version' => ['craft_cms/unknown', null, StackType::CRAFT_CMS],

            'Statamic 4' => ['statamic/4', '4', StackType::STATAMIC],
            'Statamic unknown version' => ['statamic/unknown', null, StackType::STATAMIC],
        ];
    }
}
