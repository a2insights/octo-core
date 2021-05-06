<?php

namespace Octo\Resources\Components;

use Octo\Resources\Components\Traits\Icon;
use Octo\Resources\Components\Traits\Navigation;

abstract class Menu extends Component
{
    use Navigation, Icon;

    /**
     * Menu items
     *
     * @var array|object
     */
    public $items;

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
