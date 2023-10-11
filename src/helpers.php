<?php

use Illuminate\Support\Facades\App;
use Octo\Octo;

if (! function_exists('octo')) {
    /**
     * Return Octo instance
     *
     * @return Octo
     */
    function octo()
    {
        return App::make(Octo::class);
    }
}
