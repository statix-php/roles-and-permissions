<?php

namespace Statix\Sentra\Concerns;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionEnumUnitCase;
use Statix\Sentra\Attributes\Roles\Describe;

trait AsRole
{
    public function getLabel(): string
    {
        /** @var BackedEnum $this */
        $reflection = new ReflectionEnumUnitCase(self::class, $this->name);

        $attributes = $reflection->getAttributes(Describe::class);

        $label = null;

        if (count($attributes) > 0) {
            /** @var Describe $describe */
            $describe = $attributes[0]->newInstance();

            /** @var AsRole $this */
            $label = $describe->label ?: $this->convertToHumanReadableLabel();
        }

        return $label ?: $this->convertToHumanReadableLabel();
    }

    protected function convertToHumanReadableLabel(): string
    {
        /** @var BackedEnum $this */
        return Str::of($this->name)->headline()->replace('_', ' ');
    }

    public function getDescription(): ?string
    {
        /** @var BackedEnum $this */
        $reflection = new ReflectionEnumUnitCase(self::class, $this->name);

        $attributes = $reflection->getAttributes(Describe::class);

        $description = null;

        if (count($attributes) > 0) {
            /** @var Describe $describe */
            $describe = $attributes[0]->newInstance();

            $description = $describe->description ?: null;
        }

        return $description;
    }

    public function getMeta(mixed $key = null, mixed $default = null): mixed
    {
        /** @var BackedEnum $this */
        $reflection = new ReflectionEnumUnitCase(self::class, $this->name);

        $attributes = $reflection->getAttributes(Describe::class);

        $meta = collect();

        if (count($attributes) > 0) {
            /** @var Describe $describe */
            $describe = $attributes[0]->newInstance();

            $meta = collect($describe->meta ?: []);
        }

        if (is_null($key)) {
            return $meta;
        }

        if ($meta->has($key)) {
            return $meta->get($key);
        }

        return $default;
    }

    public function getPermissions(bool $includeIndirectPermissions = true): Collection
    {
        /** @var BackedEnum $this */
        $reflection = new ReflectionEnumUnitCase(self::class, $this->name);

        $attributes = $reflection->getAttributes(Describe::class);

        $permissions = collect();

        if (count($attributes) > 0) {
            /** @var Describe $describe */
            $describe = $attributes[0]->newInstance();

            $permissions = collect($describe->permissions ?: []);
        }

        if ($includeIndirectPermissions) {
            /** @var AsRole $this */
            $permissions = $permissions->merge($this->getIndirectPermissions());
        }

        return $permissions;
    }

    public function getDirectPermissions(): Collection
    {
        return $this->getPermissions(false);
    }

    public function getIndirectPermissions(): Collection
    {
        $permissions = collect();

        /** @var BackedEnum $enumClass */
        $enumClass = config('sentra.permissions_enum');

        $enum = collect($enumClass::cases());

        $permissions = $permissions->merge($enum->filter(function ($permission) {
            /** @var AsPermission $permission */
            return $permission->getRoles(false)->contains($this);
        }));

        return $permissions;
    }

    public function can(BackedEnum $permission): bool
    {
        return $this->hasPermission($permission);
    }

    public function cannot(BackedEnum $permission): bool
    {
        return ! $this->hasPermission($permission);
    }

    public function hasPermission(BackedEnum $permission): bool
    {
        return $this->getPermissions()->contains($permission);
    }

    public function hasDirectPermission(BackedEnum $permission): bool
    {
        return $this->getDirectPermissions()->contains($permission);
    }

    public function hasIndirectPermission(BackedEnum $permission): bool
    {
        return $this->getIndirectPermissions()->contains($permission);
    }

    /**
     * @param  BackedEnum[]  $permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        $assigned = $this->getPermissions()->map(fn ($permission) => $permission->value);

        $check = collect($permissions)->map(fn ($permission) => $permission->value);

        return $assigned->intersect($check)->isNotEmpty();
    }

    /**
     * @param  BackedEnum[]  $permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        $assigned = $this->getPermissions()->map(fn ($permission) => $permission->value);

        $check = collect($permissions)->map(fn ($permission) => $permission->value);

        return $assigned->intersect($check)->count() === $check->count();
    }

    public static function rolesWithPermission(BackedEnum $permission): Collection
    {
        /** @var BackedEnum $enumClass */
        $enumClass = config('sentra.roles_enum');

        $enum = collect($enumClass::cases());

        return $enum->filter(function ($role) use ($permission) {
            /** @var AsRole $role */
            return $role->hasPermission($permission);
        });
    }

    public static function rolesWithoutPermission(BackedEnum $permission): Collection
    {
        /** @var BackedEnum $enumClass */
        $enumClass = config('sentra.roles_enum');

        $enum = collect($enumClass::cases());

        return $enum->filter(function ($role) use ($permission) {
            /** @var AsRole $role */
            return ! $role->hasPermission($permission);
        });
    }
}
