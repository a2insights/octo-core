<?php

namespace Octo\Resources\Components\Blade;

use Illuminate\View\Component as BaseComponent;

class BComponent extends BaseComponent
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
