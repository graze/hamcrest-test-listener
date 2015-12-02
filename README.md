# graze/hamcrest-test-listener

[![Build Status][ico-build]][travis]
[![Latest Version][ico-package]][package]
[![PHP ~5.6][ico-engine]][lang]
[![MIT Licensed][ico-license]][license]

A PHPUnit test listener for the hamcrest assertion library.

## Installation

```bash
~$ composer require --dev graze/hamcrest-test-listener
```

## Usage

 In your **phpunit.xml** file, add the following:

```xml
<phpunit>
    <listeners>
        <listener class="\Hamcrest\Adapter\PHPUnit\TestListener"></listener>
    </listeners>
</phpunit>
```

<!-- Links -->
[travis]: https://travis-ci.org/graze/hamcrest-test-listener
[lang]: https://secure.php.net
[package]: https://packagist.org/packages/graze/hamcrest-test-listener
[license]: https://github.com/graze/hamcrest-test-listener/blob/master/LICENSE

<!-- Images -->
[ico-license]: https://img.shields.io/packagist/l/graze/hamcrest-test-listener.svg
[ico-package]: https://img.shields.io/packagist/v/graze/hamcrest-test-listener.svg
[ico-build]: https://img.shields.io/travis/graze/hamcrest-test-listener/master.svg
[ico-engine]: https://img.shields.io/badge/php-%3E%3D5.6-8892BF.svg
