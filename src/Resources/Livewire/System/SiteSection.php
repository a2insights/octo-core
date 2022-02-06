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
    public $image_position;
    public $title_color;
    public $description_color;
    public $theme;
    public $theme_color;

    protected $rules = [
        'name' => 'required|string',
        'image' => 'nullable',
        'image_position' => 'nullable',
        'content' => 'nullable|string',
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
            $this->name = $section['name'];
            $this->content = $section['content'];
            $this->image_path = $section['image_path'] ?? null;
            $this->image_url = $section['image_url'] ?? null;
            $this->image_position = $section['image_position'] ?? null;
            $this->theme = $section['theme'] ?? null;
            $this->theme_color = $section['theme_color'] ?? '#2196f3';
            $this->title_color = $section['title_color'] ?? '#fff';
            $this->description_color = $section['description_color'] ?? '#fff';
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
            'name' => $this->name,
            'content' => $this->content,
            'image_position' => $this->image_position ?? null,
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
            'name' => $this->name,
            'content' => $this->content,
            'image_position' => $this->image_position ?? null,
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
