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
            /** @var BackedEnum $enumClass */
            $enumClass = config('sentra.permissions_enum');

            $enum = collect($enumClass::cases());

            $permissions = $permissions->merge($enum->filter(function ($permission) {
                /** @var AsPermission $permission */
                return $permission->getRoles(false)->contains($this);
            }));
        }

        return $permissions;
    }

    public function directPermissions(): Collection
    {
        return $this->getPermissions(false);
    }

    public function indirectPermissions(): Collection
    {
        return $this->getPermissions()->diff($this->directPermissions());
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
        return $this->directPermissions()->contains($permission);
    }

    public function hasIndirectPermission(BackedEnum $permission): bool
    {
        return $this->indirectPermissions()->contains($permission);
    }

    /**
     * @param  BackedEnum[]  $permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        return $this->getPermissions()->intersect($permissions)->isNotEmpty();
    }

    /**
     * @param  BackedEnum[]  $permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        $permissions = collect($permissions);

        return $this->getPermissions()->intersect($permissions)->count() === $permissions->count();
    }
}
