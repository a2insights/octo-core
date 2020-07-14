<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component;
use Octo\Resources\Components\Traits\Navigation;

class SidebarMaterial extends Component
{
    use Navigation;

    public function render()
    {
        return view('octo::components.sidebar-material');
    }
}
