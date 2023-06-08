<?php

namespace Octo\User;

use Spatie\LaravelData\Data;

class Settings extends Data
{
    public function __construct(
        public string $locale,
    ) {
    }
}
