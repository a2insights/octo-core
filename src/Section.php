<?php

namespace Octo;

use Illuminate\Support\Str;

class Section extends ObjectPrototype
{
    protected $attributes = [
        'id', 'title', 'description', 'image_url',
        'image_path', 'image_align', 'title_color',
        'description_color', 'theme', 'theme_color',
    ];

    public function setIdAttribute($value)
    {
        return $value ? $value : Str::random();
    }
}
