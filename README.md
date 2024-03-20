<p align="center">
<a href="https://larazeus.com"><img src="https://larazeus.com/images/lara-zeus-tartarus.png?v=1" /></a>
</p>

<h4 align="center">Lara-zeus Tartarus, simple multi tenants with panels</h4>

<p align="center">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lara-zeus/tartarus.svg?style=flat-square)](https://packagist.org/packages/lara-zeus/tartarus)
[![Tests](https://img.shields.io/github/actions/workflow/status/lara-zeus/tartarus/run-tests.yml?label=tests&style=flat-square&branch=main)](https://github.com/lara-zeus/tartarus/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style](https://img.shields.io/github/actions/workflow/status/lara-zeus/tartarus/fix-php-code-style-issues.yml?label=code-style&flat-square)](https://github.com/lara-zeus/tartarus/actions?query=workflow%3Afix-php-code-style-issues+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lara-zeus/tartarus.svg?style=flat-square)](https://packagist.org/packages/lara-zeus/tartarus)
[![Total Downloads](https://img.shields.io/github/stars/lara-zeus/tartarus?style=flat-square)](https://github.com/lara-zeus/tartarus)

</p>

## Support Filament

<a href="https://github.com/sponsors/danharrin">
<img alt="filament-logo" src="https://larazeus.com/images/filament-sponsor-banner.png">
</a>

## features
- 🔥 built with [filament](https://filamentadmin.com)

And more on the way.

## Documentation

### install

`composer require lara-zeus/tartarus`

## setup

add locales to zeus-tartarus.php

```php
'locales' => [
    'en' => ['name' => 'English', 'native' => 'English', 'regional' => 'en_GB', 'flag' => 'gb'],
],
```
### Env:

`CENTRAL_DOMAIN=domain.test`

### config

- filament-logger.php:
```php
    'activity_resource' => \LaraZeus\Erebus\Filament\Clusters\Employees\Resources\ActivityResource::class,
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on recent changes.

## Support
available support channels:

* open an issue on [GitHub](https://github.com/lara-zeus/tartarus/issues)
* Email us using the [contact center](https://larazeus.com/contact-us)

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you find any security-related issues, please email info@larazeus.com instead of using the issue tracker.

## Credits

-   [php coder](https://github.com/atmonshi)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please have a look at [License File](LICENSE.md) for more information.
