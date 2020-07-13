<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component;

class CounterMaterial extends Component
{
    public $title;

    public $stats;

    public $count;

    public $icon;

    public $variant;

    public function __construct(
        $count,
        $title = null,
        $stats = null,
        $icon = null,
        $variant = 'primary'
    )
    {
        $this->title = $title;
        $this->stats = json_decode(json_encode($stats));
        $this->count = $count;
        $this->icon = $icon;
        $this->variant= $variant;
    }

    public function render()
    {
        return view('octo::components.counter-material');
    }

    public function isStats()
    {
        return $this->stats !== '#';
    }
}
