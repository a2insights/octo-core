<?php

namespace Octo\Resources\Livewire\System;

use Illuminate\Support\Facades\Storage;
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
    public $image_url;
    public $image_path;

    protected $rules = [
        'name'    => 'required|string',
        'image'   => 'nullable',
        'content' => 'nullable|string',
    ];

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function mount($section = null)
    {
        if ($section) {
            $this->section_id = $section['id'];
            $this->name = $section['name'];
            $this->content = $section['content'];
            $this->image_path = $section['image_path'] ?? null;
            $this->image_url = $section['image_url'] ?? null;;
        }
    }

    public function submit()
    {
        $this->resetErrorBag();

        $this->validate();

        $image_path = $this->image instanceof TemporaryUploadedFile ? $this->image->store('site/sections' ,[
            'disk' => 'public',
        ]) : null;

        $image_url = $image_path ? Storage::disk('public')->url($image_path) : null;

        $updated = Site::saveSection([
            'id'         => $this->section_id,
            'name'       => $this->name,
            'content'    => $this->content,
            'image_path' => $image_path ? $image_path : $this->image_path,
            'image_url'  => $image_url ? $image_url : $this->image_url,
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
        $this->image_path = null;
        $this->image_url = null;

        Site::saveSection([
            'id'         => $this->section_id,
            'name'       => $this->name,
            'content'    => $this->content,
            'image_path' => null,
            'image_url'  => null,
        ]);
    }

    public function render()
    {
        return view('octo::livewire.system.site.site-section');
    }
}
