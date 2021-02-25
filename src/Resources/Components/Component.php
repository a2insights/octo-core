<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component as Base;

class Component extends Base
{
    public $view;

    public function render()
    {
        return view($this->view);
    }
}
