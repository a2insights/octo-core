<?php

namespace Octo\Resources\Livewire\System;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Octo;

class SiteSections extends Component
{
    use InteractsWithBanner;

    public array $sections = [];

    protected $listeners = ['refreshSectionsList' => '$refresh'];

    public function mount()
    {
        $this->sections = Octo::site()->sections;
    }

    public function render()
    {
        $this->sections = Octo::site()->sections;

        return view('octo::livewire.system.site.site-sections');
    }

    public function delete($id)
    {
        $deleted = Octo::site()->deleteSection($id);

        if ($deleted) {
            $this->banner('Section deleted successfully.');
        } else {
            $this->dangerBanner('There was an error deleting the section.');
        }
    }

    public function updateSectionsOrder($sections)
    {
        Octo::site()->updateSectionsOrder($sections);
    }
}
