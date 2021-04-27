<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component as BaseComponent;
use Octo\Resources\Components\Traits\Props;

class Component extends BaseComponent
{
    use Props;

    /**
     * The view should be render.
     *
     * @var string
     */
    protected $view;

    /**
     * Cast props and get the view contents.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        $this->castProps();

        return view($this->view);
    }
}
