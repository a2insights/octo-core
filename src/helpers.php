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

if (!function_exists('if_feature_is_enabled')) {
    /**
     * Perform action if feature is enabled
     *
     * @param string $feature
     * @param function $callback
     * @return bool
     */
    function if_feature_is_enabled($feature, $callback)
    {
        // TODO: implement with some package
        if (feature($feature)) {
            return $callback();
        }

        return false;
    }
}

if (!function_exists('feature')) {
    /**
     * Check if feature is enabled
     *
     * @param string $feature
     * @return bool
     */
    function feature($feature)
    {
        // TODO: implement with some package
        $features = config('octo.features');

        if (isset($features[$feature]) && $features[$feature]) {
            return true;
        }

        return false;
    }
}
