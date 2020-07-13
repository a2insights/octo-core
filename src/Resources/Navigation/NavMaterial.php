<?php

namespace Octo\Resources\Navigation;

use Illuminate\View\Component;

class NavMaterial extends Component
{
    public $items;

    public function __construct(array $items)
    {
        $this->items = json_decode(json_encode($items));
    }

    public function render()
    {
        return view('octo::components.nav-material');
    }
}
