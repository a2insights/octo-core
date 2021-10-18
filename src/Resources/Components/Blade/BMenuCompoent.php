<?php

namespace Octo\Resources\Components\Blade;

use Octo\Resources\Components\Mixins\Icon;
use Octo\Resources\Components\Mixins\LNavigationMixin;

abstract class BMenuCompoent extends BComponent
{
    use LNavigationMixin, Icon;

    /**
     * BMenuCompoent items
     *
     * @var array|object
     */
    public $items;

    /**
     * BMenuCompoent constructor.
     *
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }
}
