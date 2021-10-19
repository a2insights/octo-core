<?php

namespace Octo\Resources\Concerns;

trait Navigation
{
    /**
     * Determine if item route is active
     *
     * @param $item
     * @return bool
     */
    public function isActive($item): bool
    {
        if (is_string($item['route'])){
            return isset($item['route']) && if_route($item['route']) ?? true;
        }

        if (is_array($item['route'])){
            return isset($item['route']['name']) && if_route($item['route']['name']) ?? true;
        }

        return false;
    }

    /**
     * Determine if item has a child route active
     *
     * @param $item
     * @return bool
     */
    public function hasChildActive($item): bool
    {
        return isset($item['children']) && if_route(collect($item['children'])->pluck('route')->toArray());
    }

    /**
     * Get url for the given item route
     *
     * @param $item
     * @return string
     */
    public function getUrl($item)
    {
        if (is_array($item['route'])){
            return route($item['route']['name'], $item['route']['parameters'] ?? []);
        }

        return $item['url'] ?? route($item['route']);
    }
}
