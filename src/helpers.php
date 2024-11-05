<?php

use A2insights\FilamentSaas\FilamentSaas;
use Illuminate\Support\Facades\App;

if (! function_exists('filament_saas')) {
    /**
     * Return FilamentSaas instance
     *
     * @return FilamentSaas
     */
    function filament_saas()
    {
        return App::make(FilamentSaas::class);
    }
}
