<?php

use Octo\Console\SetupDemoCommand;
use Octo\Octo;

if (!function_exists('octo')) {
    /**
     * Return the demo fields values
     *
     * @return $value Octo
     */
    function octo()
    {
        return app(Octo::class);
    }
}
