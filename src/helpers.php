<?php

if (!function_exists('___')) {
    /**
     * Compose translation
     *
     * @param array $values
     * @return string
     */
    function ___(...$values)
    {
       return collect($values)->map(fn($v) => __($v))->implode(' ');
    }
}

if (!function_exists('octo_route')) {
    /**
     * Return the octo_route
     *
     * @param $name
     * @param $params
     * @return stdClass
     */
    function octo_route($name, $params = []) {
        $route = new \stdClass;
        $route->name = $name;
        $route->params = $params;
        if (!is_array($params)) {
            $route->params = [];
            $route->params['id'] = $params;
        }
        $route->uri = route($name, $params);
        $route->urn = explode('/api', $route->uri)[1];

        return $route;
    }
}

if (!function_exists('octo_action')) {
    /**
     * Factory octo action
     *
     * @param $name
     * @param $params
     * @return \Octo\Resources\Components\Quasar\OActionQuasar
     */
    function octo_action($name, $params)
    {
        return (new \Octo\Resources\Components\Quasar\OActionQuasar(octo_route($name, $params)));
    }
}
