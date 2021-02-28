<?php

namespace Octo\Resources\Components;

use Octo\Resources\Components\Traits\Icon;
use Octo\Resources\Components\Traits\Navigation;

class Menu extends Component
{
    use Navigation, Icon;

    public $items;

    protected $props = ['items'];

    protected $casts = [
        'items' => 'objects'
    ];

    public function __construct($items)
    {
        $this->items = $items;
    }
}
