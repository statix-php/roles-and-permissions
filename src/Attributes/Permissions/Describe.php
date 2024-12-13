<?php

namespace Statix\Sentra\Attributes\Permissions;

use Attribute;
use BackedEnum;
use Illuminate\Support\Collection;
use Statix\Sentra\Attributes\BaseDescribe;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Describe extends BaseDescribe
{
    public Collection $roles;

    /**
     * Describe and enrich the permission with additional information.
     *
     * @param  BackedEnum[]|null  $roles
     */
    public function __construct(
        ?string $label = null,
        ?string $description = null,
        array $roles = [],
        array $meta = []
    ) {
        parent::__construct($label, $description, $meta);

        $this->roles = collect($roles);
    }
}
