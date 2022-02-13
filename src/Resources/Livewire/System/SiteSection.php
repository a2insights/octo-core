<?php

namespace Octo\Resources\Livewire\System;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Octo\Octo;
use Octo\Resources\Livewire\Concerns\ValidateState;
use Octo\Section;
use Octo\Site;

class SiteSection extends ModalComponent
{
    use InteractsWithBanner;
    use WithFileUploads;
    use ValidateState;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The section image.
     *
     * @var
     */
    public $image;

    /**
     * The mount function.
     *
     * @param  array  $state
     * @return void
     */
    public function mount($state = null)
    {
        $this->state = $state ?? [];
    }

    /**
     * The component' rules.
     *
     * @var array
     */
    protected function rules()
    {
        return app(Section::class)->rules();
    }

    /**
     * The modal size.
     *
     * @var array
     */
    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    /**
     * The render function.
     *
     * @var array
     */
    public function submit()
    {
        $this->resetErrorBag();

        $this->validate();

        $image_path = $this->image instanceof TemporaryUploadedFile ? $this->image->store('site/sections' ,[
            'disk' => 'public',
        ]) : null;

        $this->state['image_url'] = $image_path ? Storage::disk('public')->url($image_path) : null;
        $this->state['image_path'] = $image_path;

        $updated = Octo::site()->saveSection($this->state);

        if ($updated) {
            $this->banner('Site section updated successfully.');
        } else {
            $this->dangerBanner('There was an error updating the site section.');
        }

        $this->emit('refreshSectionsList');

        $this->closeModal();
    }

    public function deleteImage()
    {
        $this->state['image_path'] = null;
        $this->state['image_url'] = null;
        $this->image = null;
    }

    public function render()
    {
        return view('octo::livewire.system.site.site-section');
    }
}
