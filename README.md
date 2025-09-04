# PHP Stack Detector

This library allows to easily detect the PHP stack (Wordpress, Laravel, Symfony…) and the version used, when parsing a directory or ar Github remote repository.

Supported Stacks for now:

- Bolt CMS
- Cakephp
- Codeigniter
- Craft CMS
- Drupal
- Grav CMS
- Laravel
- Leaf PHP
- Lunar
- October CMS
- Shopware
- Statamic
- Symfony
- Tempest
- Twill
- Typo3 CMS
- Winter CMS
- Wordpress

## Install

```
composer require einenlum/php-stack-detector
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\Factory\FilesystemDetectorFactory;
use Einenlum\PhpStackDetector\Factory\GithubDetectorFactory;
use Einenlum\PhpStackDetector\Enum\StackType;

// Local usage

$factory = new FilesystemDetectorFactory();
$detector = $factory->create();
$config = $detector->getFullConfiguration('/path/to/a/symfony/directory');

$phpConfiguration = $config->phpConfiguration;

// value from config platform php
$phpConfiguration->phpVersion->version; // 8.3
// value from require php
$phpConfiguration->phpVersion->requirements; // ^7.2|^8.0
$phpConfiguration->requiredExtensions; // ['intl', 'curl']

$stack = $config->stack;

$stack->type === StackType::SYMFONY;
$stack->version; // 5.4

$stack = $detector->getStack('/path/to/an/unknown/symfony/version/directory');
$stack->type === StackType::SYMFONY;
$stack->version; // null

$stack = $detector->getStack('/path/to/an/unknown/stack/directory');
$stack; // null

// For Github usage

$factory = new GithubDetectorFactory();
$detector = $factory->create();

$config = $detector->getFullConfiguration('/path/to/a/symfony/directory');

$phpConfiguration = $config->phpConfiguration;
// value from config platform php
$phpConfiguration->phpVersion->version; // 8.3
// value from require php
$phpConfiguration->phpVersion->requirements; // ^7.2|^8.0
$phpConfiguration->requiredExtensions; // ['intl', 'curl']

$stack = $config->stack;

$stack->type === StackType::SYMFONY;
$stack->version; // 6.3.0

// You can also pass an already authenticated Github Client
$client = new \Github\Client();
$client->authenticate('some_access_token', null, \Github\AuthMethod::ACCESS_TOKEN);
$detector = $factory->create($client);

$config = $detector->getFullConfiguration('einenlum/private-repo');

// optionally: detect the stack on a specific branch 
$config = $detector->getFullConfiguration('einenlum/private-repo:branch-name');
```

You can also use the CLI to test it.

```
php bin/detect-local.php ~/Prog/php/my_project/
Detected PHP version: Unknown version
Detected PHP requirements: ^8.4
Required extensions: ctype, iconv, redis, sodium
Detected stack: laravel
Version: 10.19.0

php bin/detect-github.php 'symfony/demo'
Detected PHP version: 8.4
Detected PHP requirements: ^8.3
Required extensions: ctype, iconv
Detected stack: symfony
Version: 6.3.0
```

It is advised to use an access token for github parsing, to either access private repositories or avoid reaching Github API limit.

```
GITHUB_ACCESS_TOKEN=my_token php bin/detect-github.php 'einenlum/private-repo'
Detected stack: laravel
Version: 10.19.0
```

### Usage with Symfony

Declare the factory and the detector in your `services.yaml` file.

For Github:

```yaml
services:
    Einenlum\PhpStackDetector\Factory\GithubDetectorFactory: ~

    Einenlum\PhpStackDetector\Detector:
        factory: ['@Einenlum\PhpStackDetector\Factory\GithubDetectorFactory', 'create']
        arguments:
            $client: '@Github\Client'
```

For local filesystem:

```yaml
services:
    Einenlum\PhpStackDetector\Factory\FilesystemDetectorFactory: ~

    Einenlum\PhpStackDetector\Detector:
        factory: ['@Einenlum\PhpStackDetector\Factory\FilesystemDetectorFactory', 'create']
```

## Tests

```
composer run test
```

## Coding standards

```
# check CS
composer run test-cs
```

```
# fix CS
composer run fix-cs
```

## Run interactive shell with docker

```shell
docker run --rm -it -v "$PWD":/app -w /app  php:8.4-cli bash
```

## Contribute

Each stack has its own Detector implementing a [StackDetectorInterface](src/StackDetectorInterface.php).
If the stack uses composer you can use the [PackageVersionProvider](src/Composer/PackageVersionProvider.php) class.
This will use a [ComposerConfigProvider](src/Composer/ComposerConfigProvider.php) to get the lock or the json config.

All of them use an Adapter, that is for now either [FilesystemAdapter](src/DirectoryCrawler/FilesystemAdapter.php) or [GithubAdapter](src/DirectoryCrawler/GithubAdapter.php)

You can add your own StackDetector and then add it to the `getStackDetectors` method of the [HasStackDetectors](src/Factory/HasStackDetectors.php) trait.

Any Pull Request welcome!
