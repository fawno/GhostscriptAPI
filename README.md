[![GitHub license](https://img.shields.io/github/license/fawno/GhostscriptAPI)](https://github.com/fawno/GhostscriptAPI/blob/master/LICENSE)
[![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/fawno/GhostscriptAPI)](https://github.com/fawno/GhostscriptAPI/tags)
[![Packagist](https://img.shields.io/packagist/v/fawno/gsapi)](https://packagist.org/packages/fawno/gsapi)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fawno/gsapi)](https://packagist.org/packages/fawno/gsapi/stats)
[![GitHub issues](https://img.shields.io/github/issues/fawno/GhostscriptAPI)](https://github.com/fawno/GhostscriptAPI/issues)
[![GitHub forks](https://img.shields.io/github/forks/fawno/GhostscriptAPI)](https://github.com/fawno/GhostscriptAPI/network)
[![GitHub stars](https://img.shields.io/github/stars/fawno/GhostscriptAPI)](https://github.com/fawno/GhostscriptAPI/stargazers)

# GhostscriptAPI
PHP wrapper class for [Ghostscript API](https://ghostscript.com/doc/current/API.htm)

# Requirements
- PHP >= 7.4.0
- ext-ffi ([Foreign Function Interface extension](https://www.php.net/manual/en/book.ffi.php))

## Instalation

```sh
php composer.phar require "fawno/gsapi"
```

```php
<?php
  require __DIR__ . '/vendor/autoload.php';

  use Fawno\GhostscriptAPI\GSAPI;
```
