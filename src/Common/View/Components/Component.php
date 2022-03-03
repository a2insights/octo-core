<?php

namespace Octo\Common\View\Components;

use Illuminate\View\Component as BaseComponent;

class Component extends BaseComponent
{
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
        return view($this->view);
    }
}
