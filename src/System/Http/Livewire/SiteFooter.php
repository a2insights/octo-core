<?php

namespace Octo\System\Http\Livewire;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;
use Octo\Octo;

class SiteFooter extends ModalComponent
{
    use InteractsWithBanner;
    use WithFileUploads;

    public $links = [];
    public $network = [];
    public $sorting = false;

    protected $rules = [
        'links' => 'nullable',
        'networks' => 'nullable',
    ];

    public function mount()
    {
        $this->links = Octo::site()->footer['links'] ?? [];
        $this->networks = Octo::site()->footer['networks'] ?? [];
    }

    public function render()
    {
        if (!$this->sorting) {
            $this->updateData();
        } else {
            $this->links = Octo::site()->footer['links'] ?? [];
            $this->networks = Octo::site()->footer['networks'] ?? [];
            $this->sorting = false;
        }

        return view('octo::system.site.site-footer');
    }

    public function addLink()
    {
        array_unshift($this->links, [
            'id' => Str::random(10),
            'title' => 'Title',
            'url' => 'https://example.com',
        ]);

        $this->updateData();
    }

    public function addNetwork()
    {
        array_unshift($this->networks, [
            'id' => Str::random(10),
            'title' => 'Facebook',
            'url' => 'https://facebook.com',
        ]);

        $this->updateData();
    }

    public function updateData()
    {
        Octo::site()->updateFooter([
            'links' => $this->links,
            'networks' => $this->networks,
        ]);
    }

    public function deleteLink($id)
    {
        $this->links = array_filter($this->links, function ($link) use ($id) {
            return $link['id'] !== $id;
        });

        $this->updateData();
    }

    public function deleteNetwork($id)
    {
        $this->networks = array_filter($this->networks, function ($network) use ($id) {
            return $network['id'] !== $id;
        });

        $this->updateData();
    }

    public function updateFooterLinksOrder($links)
    {
        $this->sorting = true;

        Octo::site()->updateFooterLinksOrder($links);
    }

    public function updateFooterNetworksOrder($networks)
    {
        $this->sorting = true;

        Octo::site()->updateFooterNetworksOrder($networks);
    }
}
