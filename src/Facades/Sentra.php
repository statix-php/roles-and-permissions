<?php

namespace Statix\Sentra\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Statix\Sentra\Sentra
 */
class Sentra extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Statix\Sentra\Sentra::class;
    }
}
