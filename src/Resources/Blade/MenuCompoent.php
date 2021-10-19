<?php

namespace Octo\Resources\Blade;

use Octo\Resources\Concerns\Icon;
use Octo\Resources\Concerns\Navigation;

abstract class MenuCompoent extends Component
{
    use Navigation, Icon;

    /**
     * MenuCompoent items
     *
     * @var array|object
     */
    public $items;

    /**
     * MenuCompoent constructor.
     *
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }
}
