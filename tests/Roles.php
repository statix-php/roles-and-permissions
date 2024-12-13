<?php

namespace Statix\Sentra\Tests;

use Statix\Sentra\Attributes\Roles\Describe;
use Statix\Sentra\Concerns\AsRole;

enum Roles: string
{
    use AsRole;

    #[Describe(
        label: 'Super Admin',
        description: 'Super admin role, can access all features. Can access admin features.',
    )]
    case SuperAdmin = 'super_admin';

    #[Describe(
        label: 'Standard User',
        description: 'Standard user role, can access basic features. Can not access admin features.',
        permissions: [
            Permissions::CREATE_POST,
            Permissions::UPDATE_POST,
        ]
    )]
    case StandardUser = 'standard_user';

    #[Describe(
        label: 'Admin User',
        description: 'Admin user role, can access all features. Can access admin features.',
        permissions: [
            Permissions::CREATE_POST,
            Permissions::UPDATE_POST,
            Permissions::DELETE_POST,
        ]
    )]
    case AdminUser = 'admin_user';

    #[Describe(
        description: 'No set label role',
    )]
    case NoSetLabel = 'no_set_label';

    #[Describe(
        label: 'No Set Description',
    )]
    case NoSetDescription = 'no_set_description';

    #[Describe(
        label: 'Canned Label',
        description: 'Canned description',
    )]
    case CannedDescription = 'canned_description';

    #[Describe(
        label: 'With Permissions',
        permissions: [
            Permissions::PermissionOne,
        ]
    )]
    case WithPermissions = 'with_permissions';

    #[Describe(
        label: 'Role With Meta',
        meta: [
            'key' => 'value',
        ],
    )]
    case RoleWithMeta = 'role_with_meta';
}
