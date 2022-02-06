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

    public $title;
    public $section_id;
    public $description;
    public $image;
    public $image_url;
    public $image_path;
    public $image_align;
    public $title_color;
    public $description_color;
    public $theme;
    public $theme_color;

    protected $rules = [
        'title' => 'required|string',
        'image' => 'nullable',
        'image_align' => 'nullable',
        'description' => 'nullable|string',
        'title_color' => 'nullable',
        'description_color' => 'nullable',
        'theme' => 'nullable',
        'theme_color' => 'nullable',
    ];

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function mount($section = null)
    {
        if ($section) {
            $this->section_id = $section['id'];
            $this->title = $section['title'];
            $this->description = $section['description'];
            $this->image_path = $section['image_path'] ?? null;
            $this->image_url = $section['image_url'] ?? null;
            $this->image_align = $section['image_align'] ?? null;
            $this->theme = $section['theme'] ?? null;
            $this->theme_color = $section['theme_color'] ?? '';
            $this->title_color = $section['title_color'] ?? '';
            $this->description_color = $section['description_color'] ?? '';
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
            'id' => $this->section_id,
            'title' => $this->title,
            'description' => $this->description,
            'image_align' => $this->image_align ?? null,
            'image_path' => $image_path ? $image_path : $this->image_path,
            'image_url'  => $image_url ? $image_url : $this->image_url,
            'title_color' => $this->title_color ?? null,
            'description_color' => $this->description_color ?? null,
            'theme_color' => $this->theme_color ?? null,
            'theme' => $this->theme ?? null,
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
            'id' => $this->section_id,
            'title' => $this->title,
            'description' => $this->description,
            'image_align' => $this->image_align ?? null,
            'image_path' => null,
            'image_url' => null,
            'title_color' => $this->title_color ?? null,
            'description_color' => $this->description_color ?? null,
            'theme_color' => $this->theme_color ?? null,
            'theme' => $this->theme ?? null,
        ]);
    }

    public function render()
    {
        return view('octo::livewire.system.site.site-section');
    }
}
