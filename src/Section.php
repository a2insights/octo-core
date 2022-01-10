<?php

namespace Octo;

use Illuminate\Support\Str;

class Section extends ObjectPrototype
{
    protected $attributes = [
        'id', 'name', 'content', 'image_url', 'image_path',
    ];

    public function setIdAttribute($value)
    {
        return $value ? $value : Str::random();
    }
}
