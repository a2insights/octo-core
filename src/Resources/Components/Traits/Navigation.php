<?php

namespace Octo\Resources\Components\Traits;

trait Navigation
{
    public function isActive($item)
    {
        return isset($item['route']) ? if_route($item['route']) : false;
    }

    public function hasChildActive($item)
    {
        return isset($item['children']) ? if_route(collect($item['children'])->pluck('route')->toArray()) : false;
    }

    public function getUrl($item)
    {
        return $item['url'] ?? route($item['route']);
    }
}
