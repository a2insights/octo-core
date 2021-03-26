<?php

namespace Octo\Resources\Components\material;

use Octo\Resources\Components\Component;

class CardMaterial extends Component
{
    public $view = 'octo::components.material.card';

    public $title;

    public $description;

    public $variant;

    public function __construct(
        string $title = null,
        string $description = null,
        string $variant = 'primary'
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->variant = $variant;
    }
}
