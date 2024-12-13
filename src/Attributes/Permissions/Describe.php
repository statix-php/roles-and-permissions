<?php

namespace Statix\Sentra\Attributes\Permissions;

use BackedEnum;
use Illuminate\Support\Collection;
use Statix\Sentra\Attributes\BaseDescribe;

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
    ) {
        parent::__construct($label, $description);

        $this->roles = collect($roles);
    }
}
