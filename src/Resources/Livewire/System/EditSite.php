<?php

namespace Octo\Resources\Livewire\System;

use Laravel\Jetstream\InteractsWithBanner;
use LivewireUI\Modal\ModalComponent;
use Octo\Site;

class EditSite extends ModalComponent
{
    use InteractsWithBanner;

    public $name;
    public $active;
    public $description;

    protected $rules = [
        'name'        => 'required|string',
        'description' => 'nullable|string',
        'active'      => 'required|boolean',
    ];

    public function mount()
    {
        $this->name = Site::getName();
        $this->description = Site::getDescription();
        $this->active = Site::getActive();
    }

    public function submit()
    {
        $this->resetErrorBag();

        $this->validate();

        $updated = Site::update([
            'name'        => $this->name,
            'active'      => $this->active,
            'description' => $this->description,
        ]);

        if ($updated) {
            $this->banner('Site updated successfully.');
            $this->emit('refreshRaceRunnersList');
        } else {
            $this->dangerBanner('There was an error updating the site.');
        }

        $this->closeModal();
    }

    public function render()
    {
        return view('octo::livewire.system.site.edit-site');
    }
}
