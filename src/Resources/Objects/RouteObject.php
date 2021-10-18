<?php

namespace Octo\Resources\Objects;

class RouteObject extends ObjectAbstract
{
    protected $attributes = [
        'name', 'params' => []
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return route($this->name, $this->params ?? []);
    }
}
