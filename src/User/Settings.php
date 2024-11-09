<?php

namespace A2Insights\FilamentSaas\User;

use Spatie\LaravelData\Data;

class Settings extends Data
{
    public function __construct(
        public string $locale,
    ) {}
}
