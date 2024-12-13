<?php

namespace Statix\Sentra\Attributes\Roles;

use BackedEnum;
use Illuminate\Support\Collection;
use Statix\Sentra\Attributes\BaseDescribe;

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
    ) {
        parent::__construct($label, $description);

        $this->permissions = collect($permissions);
    }
}
