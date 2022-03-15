<?php

namespace Octo\Marketing\Facades;

use Illuminate\Support\Facades\Facade;

class Campaign extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Campaign';
    }
}
