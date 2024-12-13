<?php

namespace Statix\Sentra\Attributes\Roles;

use Attribute;
use BackedEnum;
use Illuminate\Support\Collection;
use Statix\Sentra\Attributes\BaseDescribe;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Describe extends BaseDescribe
{
    public Collection $permissions;

    /**
     * Describe and enrich the role with additional information.
     *
     * @param  BackedEnum[]|null  $permissions
     */
    public function __construct(
        ?string $label = null,
        ?string $description = null,
        array $permissions = [],
        array $meta = []
    ) {
        parent::__construct($label, $description, $meta);

        $this->permissions = collect($permissions);
    }
}
