<?php

namespace Statix\Sentra\Tests;

use Statix\Sentra\Attributes\Permissions\Describe;
use Statix\Sentra\Concerns\AsPermission;

enum Permissions: string
{
    use AsPermission;

    #[Describe(
        label: 'Create Post',
        description: 'Ability to create a new post',
        roles: [
            Roles::SuperAdmin,
        ]
    )]
    case CREATE_POST = 'create_post';

    #[Describe(
        label: 'Update Post',
        description: 'Ability to update a post',
        roles: [
            Roles::SuperAdmin,
        ]
    )]
    case UPDATE_POST = 'update_post';

    #[Describe(
        label: 'Delete Post',
        description: 'Ability to delete a post',
        roles: [
            Roles::SuperAdmin,
        ]
    )]
    case DELETE_POST = 'delete_post';

    #[Describe(
        label: 'Permission One',
        description: 'Permission one description',
        roles: [
            Roles::SuperAdmin,
        ],
        meta: [
            'key' => 'value',
        ]
    )]
    case PermissionOne = 'permission_one';

    #[Describe(
    )]
    case PermissionWithoutLabel = 'permission_without_label';
}
