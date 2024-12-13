<?php

// it can use the config file to get the permissions enum

use Illuminate\Support\Collection;
use Statix\Sentra\Tests\Permissions;
use Statix\Sentra\Tests\Roles;

it('can use the config file to get the permissions enum', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $this->assertNotNull($permissionEnum);

    expect($permissionEnum::cases())->toBeArray();
});

// it can get the label of a permission
it('can get the label of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::CREATE_POST;

    expect($permission->getLabel())->toBe('Create Post');
});

// if a permission does not have a label, it will convert the name to a human readable label
it('can convert the name of a permission to a human readable label', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionWithoutLabel;

    expect($permission->getLabel())->toBe('Permission Without Label');
});

// it can get the description of a permission
it('can get the description of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionOne;

    expect($permission->getDescription())->toBe('Permission one description');
});

// if a permission does not have a description, it will return null
it('can return null if a permission does not have a description', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionWithoutLabel;

    expect($permission->getDescription())->toBeNull();
});

// it can get the meta of a permission
it('can get the meta of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionOne;

    $meta = $permission->getMeta();

    expect($meta)->toBeInstanceOf(Collection::class);
    expect($meta->get('key'))->toBe('value');
});

// it can get the roles of a permission
it('can get the roles of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::CREATE_POST;

    expect($permission->getRoles())->toBeInstanceOf(Collection::class);
});

// if a permission does not have roles, it will return an empty collection
it('will return an empty collection if a permission does not have roles', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionWithoutLabel;

    expect($permission->getRoles())->toBeInstanceOf(Collection::class);
    expect($permission->getRoles())->toHaveCount(0);
});

// it can get only the direct roles of a permission
it('can get only the direct roles of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::PermissionOne;

    $roles = $permission->getDirectRoles();

    expect($roles)->toBeInstanceOf(Collection::class);
    expect($roles)->toHaveCount(1);
    expect($roles->first())->toBe(Roles::SuperAdmin);
});

// it can get only the indirect roles of a permission
it('can get only the indirect roles of a permission', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::DELETE_POST;

    $roles = $permission->getIndirectRoles();

    expect($roles)->toBeInstanceOf(Collection::class);
    expect($roles)->toHaveCount(1);
    expect($roles->first())->toBe(Roles::AdminUser);
});

// it can use the attachedToRole method to check for a role
it('can use the attachedToRole method to check for a role', function () {
    /** @var Permissions $permissionEnum */
    $permissionEnum = config('sentra.permissions_enum');

    $permission = $permissionEnum::CREATE_POST;

    expect($permission->attachedToRole(Roles::SuperAdmin))->toBeTrue();

    $permission = $permissionEnum::DELETE_POST;

    expect($permission->attachedToRole(Roles::StandardUser))->toBeFalse();
});
