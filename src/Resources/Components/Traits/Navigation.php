<?php

namespace Octo\Resources\Components\Traits;

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
        return isset($item->route) ? if_route($item->route) : false;
    }

    /**
     * Determine if item has a child route active
     *
     * @param $item
     * @return bool
     */
    public function hasChildActive($item): bool
    {
        return isset($item->children) ? if_route(collect($item->children)->pluck('route')->toArray()) : false;
    }

    /**
     * Get url for the given item route
     *
     * @param $item
     * @return string
     */
    public function getUrl($item): string
    {
        return $item->url ?? route($item->route);
    }
}
