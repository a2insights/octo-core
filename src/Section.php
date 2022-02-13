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

    /**
     * Rules of Section create.
     *
     * @var array
     */
    protected $rules = [
        'title' => 'required|string',
        'title_color' => 'nullable',
        'description' => 'nullable|string',
        'description_color' => 'nullable',
        'image_align' => 'nullable',
        'image_url' => 'nullable',
        'image_path' => 'nullable',
        'theme' => 'nullable',
        'theme_color' => 'nullable',
    ];

    public function setIdAttribute($value)
    {
        return $value ? $value : Str::random();
    }
}
