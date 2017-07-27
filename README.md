# graze/hamcrest-test-listener [![Build Status][ico-build]][travis] [![Latest Version][ico-package]][package] [![MIT Licensed][ico-license]][license]

A PHPUnit test listener for the hamcrest assertion library.

## Installation

NOTE:

For PHPUnit >= 6, please use version >= 3.0

For PHPUnit < 6, please use version < 3.0

```bash
~$ composer require --dev graze/hamcrest-test-listener
```

## Usage

 In your **phpunit.xml** file, add the following:

```xml
<phpunit
    beStrictAboutTestsThatDoNotTestAnything="false"> <!-- PHPUnit will not consider Hamcrest assertions -->
    
    <listeners>
        <listener class="\Hamcrest\Adapter\PHPUnit\TestListener"></listener>
    </listeners>
</phpunit>
```

<!-- Links -->
[travis]: https://travis-ci.org/graze/hamcrest-test-listener
[package]: https://packagist.org/packages/graze/hamcrest-test-listener
[license]: https://github.com/graze/hamcrest-test-listener/blob/master/LICENSE

<!-- Images -->
[ico-license]: https://img.shields.io/packagist/l/graze/hamcrest-test-listener.svg
[ico-package]: https://img.shields.io/packagist/v/graze/hamcrest-test-listener.svg
[ico-build]: https://img.shields.io/travis/graze/hamcrest-test-listener/master.svg
