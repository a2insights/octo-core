<?php

namespace Octo\Resources\Livewire\System;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class SiteFooter extends ModalComponent
{
    use InteractsWithBanner;
    use WithFileUploads;

    public $links = [];
    public $network = [];

    protected $rules = [
        'links' => 'nullable',
        'network' => 'nullable',
    ];

    public function render()
    {
        return view('octo::livewire.system.site.site-footer');
    }

    public function addLink()
    {
        $this->links[] = [Str::random(4) => 'Title'];

        array_reverse($this->links);
    }
}
