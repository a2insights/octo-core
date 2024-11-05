<?php

namespace A2insights\FilamentSaas\User;

use Spatie\LaravelData\Data;

class Settings extends Data
{
    public function __construct(
        public string $locale,
    ) {}
}
