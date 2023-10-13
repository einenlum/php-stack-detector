# PHP Stack Detector

This library allows to easily detect the PHP stack (Wordpress, Laravel, Symfony…) and the version used, when parsing a directory.

Supported Stacks for now:

- Wordpress
- Laravel
- Symfony
- Statamic
- Craft CMS

## Install

```
composer require einenlum/php-stack-detector
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Einenlum\PhpStackDetector\Detector;
use Einenlum\PhpStackDetector\StackType;

$detector = Detector::create();
$stack = $detector->getStack('/path/to/a/symfony/directory');

$stack->type === StackType===SYMFONY;
$stack->version; // 5.4

$stack = $detector->getStack('/path/to/an/unknown/symfony/version/directory');
$stack->type === StackType===SYMFONY;
$stack->version; // null

$stack = $detector->getStack('/path/to/an/unknown/stack/directory');
$stack; // null
```

## Tests

```
composer run test
```

## Contribute

Each stack has its own Detector implementing a [StackDetectorInterface](src/StackDetectorInterface.php).
If the stack uses composer you can use the [PackageVersionProvider](src/Composer/PackageVersionProvider.php) class.

You can add your own StackDetector and then add it to the `create` method of the [Detector](src/Detector.php).

Any Pull Request welcome!
