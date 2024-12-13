<?php

namespace Statix\Sentra\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
abstract class BaseDescribe
{
    public ?string $label = null;

    public ?string $description = null;

    /**
     * Describe and enrich the enum with additional information.
     */
    public function __construct(
        ?string $label = null,
        ?string $description = null,
    ) {
        $this->label = $label;
        $this->description = $description;
    }
}
