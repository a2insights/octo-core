<?php

namespace Octo\Resources\Components\material;

use Octo\Resources\Components\Component;

class CounterMaterial extends Component
{
    protected $view = 'octo::components.counter-material';

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

    public function isStats(): bool
    {
        return $this->stats !== '#';
    }
}
