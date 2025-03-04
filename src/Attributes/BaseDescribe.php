<?php

namespace Statix\Sentra\Attributes;

abstract class BaseDescribe
{
    public ?string $label = null;

    public ?string $description = null;

    public array $meta = [];

    /**
     * Describe and enrich the enum with additional information.
     */
    public function __construct(
        ?string $label = null,
        ?string $description = null,
        array $meta = []
    ) {
        $this->label = $label;
        $this->description = $description;
        $this->meta = $meta;
    }
}
