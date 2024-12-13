<?php

use Illuminate\Support\Collection;
use Statix\Sentra\Tests\Permissions;
use Statix\Sentra\Tests\Roles;

it('can use the config file to get the roles enum', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $this->assertNotNull($roleEnum);

    expect($roleEnum::cases())->toBeArray();
});

// it can get the label of a role
it('can get the label of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    expect($role->getLabel())->toBe('Super Admin');
});

// if a role does not have a label, it will convert the name to a human readable label
it('can convert the name of a role to a human readable label', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::NoSetLabel;

    expect($role->getLabel())->toBe('No Set Label');
});

// it can get the description of a role
it('can get the description of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::CannedDescription;

    expect($role->getDescription())->toBe('Canned description');
});

// if a role does not have a description, it will return null
it('can return null if a role does not have a description', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::NoSetDescription;

    expect($role->getDescription())->toBeNull();
});

// it can get the permissions of a role
it('can get the permissions of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::WithPermissions;

    $permissions = $role->getPermissions();
    expect($permissions)->toBeInstanceOf(Collection::class);
    expect($permissions)->toHaveCount(1);
    expect($permissions->first())->toBe(Permissions::PermissionOne);
});

// it can get only the direct permissions of a role
it('can get only the direct permissions of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    $permissions = $role->getDirectPermissions();

    expect($permissions)->toBeInstanceOf(Collection::class);
    expect($permissions)->toHaveCount(0);
});

// it can get only the indirect permissions of a role
it('can get only the indirect permissions of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    $permissions = $role->getIndirectPermissions();

    expect($permissions)->toBeInstanceOf(Collection::class);
    expect($permissions->count())->toBeGreaterThan(0);
});

// it can use the can method to check for a permission
it('can use the can method to check for a permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    expect($role->can(Permissions::CREATE_POST))->toBeTrue();
});

// it can use the cannot method to check for a permission
it('can use the cannot method to check for lack of a permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::StandardUser;

    expect($role->cannot(Permissions::DELETE_POST))->toBeTrue();
});

// it can use the hasPermission method to check for a permission
it('can use the hasPermission method to check for a permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::AdminUser;

    expect($role->hasPermission(Permissions::DELETE_POST))->toBeTrue();
});

// it can use the hasDirectPermission method to check for a direct permission
it('can use the hasDirectPermission method to check for a direct permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    expect($role->hasDirectPermission(Permissions::DELETE_POST))->toBeFalse();
});

// it can use the hasIndirectPermission method to check for an indirect permission
it('can use the hasIndirectPermission method to check for an indirect permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::SuperAdmin;

    expect($role->hasIndirectPermission(Permissions::DELETE_POST))->toBeTrue();
});

// it can use the hasAnyPermission method to check for any permission
it('can use the hasAnyPermission method to check for any permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::StandardUser;

    // dd((array) $role->getPermissions(), (array) [Permissions::CREATE_POST, Permissions::DELETE_POST]);

    expect($role->hasAnyPermission([Permissions::CREATE_POST, Permissions::DELETE_POST]))->toBeTrue();
});

// it can use the hasAllPermissions method to check for all permissions
it('can use the hasAllPermissions method to check for all permissions', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::AdminUser;

    expect($role->hasAllPermissions([Permissions::CREATE_POST, Permissions::UPDATE_POST, Permissions::DELETE_POST]))->toBeTrue();

    $role = $roleEnum::StandardUser;

    expect($role->hasAllPermissions([Permissions::CREATE_POST, Permissions::UPDATE_POST, Permissions::DELETE_POST]))->toBeFalse();
});

// it can retrieve the roles that have a specific permission
it('can retrieve the roles that have a specific permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $roles = $roleEnum::rolesWithPermission(Permissions::DELETE_POST);

    expect($roles)->toBeInstanceOf(Collection::class);

    $adminUser = $roleEnum::AdminUser;

    expect($roles->contains($adminUser))->toBeTrue();
});

// it can retrieve the roles that do not have a specific permission
it('can retrieve the roles that do not have a specific permission', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $roles = $roleEnum::rolesWithoutPermission(Permissions::DELETE_POST);

    expect($roles)->toBeInstanceOf(Collection::class);

    $standardUser = $roleEnum::StandardUser;

    expect($roles->contains($standardUser))->toBeTrue();
});

// it can retrieve the meta data of a role
it('can retrieve the meta data of a role', function () {
    /** @var Roles $roleEnum */
    $roleEnum = config('sentra.roles_enum');

    $role = $roleEnum::RoleWithMeta;

    $meta = $role->getMeta();

    expect($meta->get('key'))->toBe('value');
});
