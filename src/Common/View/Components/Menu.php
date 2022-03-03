<?php

namespace Octo\Common\View\Components;

use Octo\Common\Concerns\Icon;
use Octo\Common\Concerns\Navigation;

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
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }
}
