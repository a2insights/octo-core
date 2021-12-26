<?php

namespace Octo;

class Route extends ObjectPrototype
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
