<?php

namespace Statix\Sentra\Concerns;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionEnumUnitCase;
use Statix\Sentra\Attributes\Permissions\Describe;

trait AsPermission
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

            /** @var AsPermission $this */
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

    public function getRoles(bool $includeIndirectRoles = true): Collection
    {
        /** @var BackedEnum $this */
        $reflection = new ReflectionEnumUnitCase(self::class, $this->name);

        $attributes = $reflection->getAttributes(Describe::class);

        $roles = collect();

        if (count($attributes) > 0) {
            /** @var Describe $describe */
            $describe = $attributes[0]->newInstance();

            $roles = collect($describe->roles ?: []);
        }

        if ($includeIndirectRoles) {
            /** @var BackedEnum $enumClass */
            $enumClass = config('sentra.roles_enum');

            $enum = collect($enumClass::cases());

            $roles = $roles->merge($enum->filter(function ($role) {
                /** @var AsRole $role */
                return $role->getPermissions(false)->contains($this);
            }));
        }

        return $roles;
    }

    public function getDirectRoles(): Collection
    {
        return $this->getRoles(false);
    }

    public function getIndirectRoles(): Collection
    {
        return $this->getRoles()->diff($this->getDirectRoles());
    }
}
