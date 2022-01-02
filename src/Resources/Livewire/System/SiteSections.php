<?php

namespace Octo\Resources\Livewire\System;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Site;

class SiteSections extends Component
{
    use InteractsWithBanner;

    public array $sections = [];

    protected $listeners = ['refreshSectionsList' => '$refresh'];

    public function render()
    {
        $this->sections = Site::sections();

        return view('octo::livewire.system.site.site-sections');
    }

    public function delete($id)
    {
        $deleted = Site::deleteSection($id);

        if ($deleted) {
            $this->banner('Section deleted successfully.');
        } else {
            $this->dangerBanner('There was an error deleting the section.');
        }

        $this->emit('refreshSectionsList');
    }

    public function updateSectionsOrder($sections)
    {
        Site::updateSectionsOrder($sections);
    }
}
