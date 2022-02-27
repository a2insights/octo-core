<?php

use Octo\Console\SetupCommand;
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
        return env('app.env') !== 'production' && Octo::site()->demo ? collect([
            'email' => SetupCommand::DEFAULT_USER_EMAIL,
            'password' => SetupCommand::DEFAULT_USER_PASSWORD,
            'name' => SetupCommand::DEFAULT_USER_NAME,
        ])
        ->filter(fn ($value, $key) => $key === $field)
        ->map(fn ($value, $key) => $default ? $default : $value)
        ->first() : null;
    }
}
