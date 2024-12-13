# Sentra for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/statix/roles-and-permissions.svg?style=flat-square)](https://packagist.org/packages/statix/roles-and-permissions)

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/statix/roles-and-permissions/run-tests?label=tests)]()

## Installation

You can install the package via composer:

```bash
composer require statix/sentra
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sentra"
```

This is the contents of the published config file:

```php
return [
    //
];
```

## Usage

```php

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Wyatt Castaneda](https://github.com/)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Todo 

- make it easier to assign a super-admin role, kinda of like the before method in laravel policies