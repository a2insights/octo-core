<?php

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
     * Fabrica o objeto OAction
     *
     * @param $name
     * @param $params
     * @return array|null
     */
    function octo_action($name, $params)
    {
        return (new \Octo\Resources\Components\quasar\OActionQuasar(octo_route($name, $params)))->get();
    }
}
