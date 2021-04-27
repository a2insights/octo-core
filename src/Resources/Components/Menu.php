<?php

namespace Octo\Resources\Components;

use Octo\Resources\Components\Traits\Icon;
use Octo\Resources\Components\Traits\Navigation;

class Menu extends Component
{
    use Navigation, Icon;

    /**
     * Menu items
     *
     * @var array|object
     */
    public $items;

    /**
     * The props who should be cast.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'objects'
    ];

    /**
     * Menu constructor.
     *
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }
}
