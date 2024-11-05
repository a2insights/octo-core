<?php

namespace A2insights\FilamentSaas\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \A2insights\FilamentSaas\FilamentSaas
 */
class FilamentSaas extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \A2insights\FilamentSaas\FilamentSaas::class;
    }
}
