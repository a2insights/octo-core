<?php

namespace Octo\Resources\Livewire\System;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Octo\Site;

class SiteSection extends ModalComponent
{
    use InteractsWithBanner;
    use WithFileUploads;

    public $name;
    public $section_id;
    public $content;
    public $image;

    protected $rules = [
        'name'    => 'required|string',
        'image'   => 'nullable',
        'content' => 'nullable|string',
    ];

    public function mount($section = null)
    {
        if ($section) {
            $this->section_id = $section['id'];
            $this->name = $section['name'];
            $this->content = $section['content'];
            $this->image = $section['image'] ?? null;
        }
    }

    public function submit()
    {
        $this->resetErrorBag();

        $this->validate();

        $updated = Site::saveSection([
            'id' => $this->section_id,
            'name'    => $this->name,
            'content' => $this->content,
            'image'   => $this->image instanceof TemporaryUploadedFile ? $this->image->store('site/sections') : null,
        ]);

        if ($updated) {
            $this->banner('Site updated successfully.');
        } else {
            $this->dangerBanner('There was an error updating the site.');
        }

        $this->emit('refreshSectionsList');

        $this->closeModal();
    }

    public function deleteImage()
    {
        $this->image = null;
    }

    public function render()
    {
        return view('octo::livewire.system.site.site-section');
    }
}
