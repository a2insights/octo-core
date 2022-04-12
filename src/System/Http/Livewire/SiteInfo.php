<?php

namespace Octo\System\Http\Livewire;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Octo;

class SiteInfo extends Component
{
    use InteractsWithBanner;

    public $name;
    public $active;
    public $description;
    public $demo;

    private $site;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'active' => 'required|boolean',
        'demo' => 'required|boolean',
    ];

    public function mount()
    {
        $this->site = Octo::site();

        $this->name = $this->site->name;
        $this->description = $this->site->description;
        $this->active = $this->site->active;
        $this->demo =  $this->site->demo;
    }

    public function submit()
    {
        $this->resetErrorBag();

        $this->validate();

        $this->site = Octo::site();

        $this->site->name = $this->name;
        $this->site->description = $this->description;
        $this->site->active = $this->active;
        $this->site->demo = $this->demo;

        if ($this->site->save()) {
            $this->banner('Site updated successfully.');
            $this->emit('saved');
        } else {
            $this->dangerBanner('There was an error updating the site.');
        }
    }

    public function render()
    {
        return view('octo::system.site.site-info');
    }
}
