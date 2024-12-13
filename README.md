# Sentra for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/statix/sentra.svg?style=flat-square)](https://packagist.org/packages/statix/sentra)

A lightweight Laravel roles and permissions package using Backed Enums.

## Installation

You can install the package via composer:

```bash
composer require statix/sentra
```

You should publish the config file with the following command:

```bash
php artisan vendor:publish --tag="sentra"
```

This is the contents of the published config file:

```php
return [

    /**
     * The backed enum class that will be used to define your roles.
     */
    'roles_enum' => 'App\Enums\Roles',

    /**
     * The backed enum class that will be used to define your permissions.
     */
    'permissions_enum' => 'App\Enums\Permissions',

];
```

## Usage

To get started, create two string backed Enums - one of your roles and one for your permissions.

```bash
php artisan make:enum "App\Enums\Roles" --string
php artisan make:enum "App\Enums\Permissions" --string
```

If you create your enums in a different namespace or different name, be sure to update the `roles_enum` and `permissions_enum` in the `sentra.php` config file.


Then add the `AsRole` trait to your `Roles` enum. 

```php
<?php

namespace App\Enums;

use Statix\Sentra\Attributes\Roles\Describe;
use Statix\Sentra\Concerns\AsRole;

enum Roles: string
{
    use AsRole;
}
```

And add the `AsPermission` trait to your `Permissions` enum.

```php
<?php

namespace App\Enums;

use Statix\Sentra\Attributes\Permissions\Describe;
use Statix\Sentra\Concerns\AsPermission;

enum Permissions: string
{
    use AsPermission;
}
```

You are now ready to start defining your roles and permissions.

```php
<?php

namespace App\Enums;

use Statix\Sentra\Attributes\Roles\Describe;
use Statix\Sentra\Concerns\AsRole;

enum Permissions: string
{
    use AsPermission;

    #[Describe(
        label: 'Create Posts', 
        description: 'Create new posts'
        roles: [
            Roles::SuperAdmin,
            Roles::Admin
        ]
    )]
    case CreatePosts = 'create-posts';

    #[Describe(
        label: 'Edit Posts', 
        description: 'Edit existing posts'
        roles: [
            Roles::SuperAdmin,
            Roles::Admin,
            Roles::StandardUser
        ]
    )]
    case EditPosts = 'edit-posts';

    #[Describe(
        label: 'Delete Posts', 
        description: 'Delete existing posts'
        roles: [
            Roles::SuperAdmin,
            Roles::Admin
        ]
    )]
    case DeletePosts = 'delete-posts';
}
```

```php
<?php

namespace App\Enums;

use Statix\Sentra\Attributes\Roles\Describe;
use Statix\Sentra\Concerns\AsRole;

enum Roles: string
{
    use AsRole;

    #[Describe(
        label: 'Super Admin', 
        description: 'The highest level of access'
    )]
    case SuperAdmin;

    #[Describe(
        label: 'Admin', 
        description: 'Admin level access'
    )]
    case Admin = 'admin';

    #[Describe(
        label: 'Standard User', 
        description: 'Standard user access'
    )]
    #[Describe('User')]
    case StandardUser = 'user';
}
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