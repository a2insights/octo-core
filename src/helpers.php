<?php

use Octo\Console\SetupDemoCommand;
use Octo\Octo;

if (!function_exists('demo')) {
    /**
     * Return the demo fields values
     *
     * @param string $field
     * @param array $default
     * @return $value string
     */
    function demo($field, $default = null)
    {
        $showValues = function () {
            return (config('app.env') === 'demo'
            || config('app.env') === 'local')
            && Octo::site()->demo;
        };

        return $showValues ? collect([
            'email' => SetupDemoCommand::DEFAULT_USER_EMAIL,
            'password' => SetupDemoCommand::DEFAULT_USER_PASSWORD,
            'name' => SetupDemoCommand::DEFAULT_USER_NAME,
        ])
        ->filter(fn ($value, $key) => $key === $field)
        ->map(fn ($value, $key) => $default ? $default : $value)
        ->first() : null;
    }
}
