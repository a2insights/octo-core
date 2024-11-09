<?php

namespace A2Insights\FilamentSaas\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \A2Insights\FilamentSaas\FilamentSaas
 */
class FilamentSaas extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \A2Insights\FilamentSaas\FilamentSaas::class;
    }
}
