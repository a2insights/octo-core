<?php

namespace Octo\Resources\Components\Traits;

trait Navigation
{
    public $items;

    public function __construct(array $items)
    {
        $this->items = json_decode(json_encode($items));
    }

    public function isActive($item)
    {
        return isset($item->route) && explode('.', $item->route)[0] === explode('.', request()->route()->getName())[0];
    }

    public function getUrl($item)
    {
       return $item->url ?? route($item->route);
    }

}
