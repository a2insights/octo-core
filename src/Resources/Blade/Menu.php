<?php

namespace Octo\Resources\Blade;

use Octo\Resources\Concerns\Icon;
use Octo\Resources\Concerns\Navigation;

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
