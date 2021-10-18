<?php

if (!function_exists('___')) {
    /**
     * Compose translation
     *
     * @param array $values
     * @return string
     */
    function ___(...$values) {
       return collect($values)->map(fn($v) => __($v))->implode(' ');
    }
}

if (!function_exists('octo_route')) {
    /**
     * Return the octo_route
     *
     * @param string $name
     * @param array $params
     * @return \Octo\Resources\Objects\RouteObject
     */
    function octo_route(string $name, array $params = []) {
        return new \Octo\Resources\Objects\RouteObject([
            'name' => $name,
            'params' => $params
        ]);
    }
}

if (!function_exists('octo_action')) {
    /**
     * Factory octo action
     *
     * @param $name
     * @param $params
     * @return \Octo\Resources\Components\Quasar\Objects\QActionObject
     */
    function octo_action($name, $params)
    {
        return (new \Octo\Resources\Components\Quasar\Objects\QActionObject(octo_route($name, $params)));
    }
}
