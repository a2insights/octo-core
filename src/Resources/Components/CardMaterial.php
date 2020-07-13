<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component;

class CardMaterial extends Component
{
    public $title;

    public $description;

    public $variant;

    public function __construct(string $title = null, string $description = null, $variant = 'primary')
    {
        $this->title = $title;
        $this->description = $description;
        $this->variant = $variant;
    }

    public function render()
    {
        return view('octo::components.card-material');
    }
}
