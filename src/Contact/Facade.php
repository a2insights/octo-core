<?php

namespace Octo\Contact;

use Illuminate\Support\Facades\Facade as FacadesFacade;

class Facade extends FacadesFacade
{
    protected static function getFacadeAccessor()
    {
        return 'Contact';
    }
}
