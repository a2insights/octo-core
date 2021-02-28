<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component as BaseComponent;
use Octo\Resources\Components\Traits\Props;

class  Component extends BaseComponent
{
    use Props;

    /**
     * The view should be render
     *
     * @var string
     */
    protected $view;

    /**
     * Cast props and determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender()
    {
        $this->castProps();

        return true;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view($this->view);
    }
}
