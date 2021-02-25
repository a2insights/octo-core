<?php

namespace Octo\Resources\Components;

use Octo\Resources\Components\Traits\Icon;
use Octo\Resources\Components\Traits\Navigation;

class Sidebar extends Component
{
    use Navigation, Icon;

    public $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
