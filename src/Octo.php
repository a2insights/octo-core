<?php

namespace Octo;

use Illuminate\Support\Facades\Config;

class Octo
{
    public static function getUserModel(): string
    {
        return Config::get('octo.user.model', 'App\\Models\\User');
    }
}
