<?php

if (!function_exists('octo_route')) {
    /**
     * Return the octo_route
     *
     * @param string $name
     * @param array $params
     * @return \Octo\Route
     */
    function octo_route(string $name , array $params = [])
    {
        return new \Octo\Route ([
            'name' => $name,
            'params' => $params
        ]);
    }
}
