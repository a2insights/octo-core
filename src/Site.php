<?php

namespace Octo;

use Octo\Settings\GeneralSettings;

class Site extends ObjectPrototype
{
    protected $attributes = [
        'name', 'active', 'description', 'demo',
        'footer' => ['links' => [], 'networks' => []],
        'sections' => [],
    ];

    private $settings;

    public function __construct()
    {
        $this->settings = $this->settings();

        parent::__construct($this->settings->site);
    }

    private function save()
    {
        $this->settings->site = $this->toArray();

        return $this->settings->save();
    }

    public function update($data)
    {
        $this->name = $data['name'];
        $this->active = $data['active'];
        $this->description = $data['description'];
        $this->demo = $data['demo'];

        return $this->save();
    }

    public function saveSection($section)
    {
        if (! @$section['id']) {
            return $this->addSection($section);
        }

        return $this->updateSection($section);
    }

    public function updateSection($data)
    {
        foreach ($this->sections as $key => $section) {
            if ($section['id'] === $data['id']) {
                $this->sections[$key] = $data;
                break;
            }
        }

        return $this->save();
    }

    public function deleteSection($id)
    {
        foreach ($this->sections as $key => $section) {
            if ($section['id'] === $id) {
                unset($this->sections[$key]);
                break;
            }
        }

        return $this->save();
    }

    public function addSection($data)
    {
        array_push($this->sections, (new Section($data))->toArray());

        return $this->save();
    }

    public function updateSectionsOrder($sections)
    {
        foreach ($sections as $index => $section) {
            $newOrder[$index] = collect($this->sections)->where('id', $section['value'])->first();
        }

        $this->sections = $newOrder;

        return $this->save();
    }

    public function updateFooterLinksOrder($links)
    {
        foreach ($links as $index => $link) {
            $newOrder[$index] = collect($this->footer['links'])->where('id', $link['value'])->first();
        }

        $this->footer['links'] = $newOrder;

        return $this->save();
    }

    public function updateFooterNetworksOrder($networks)
    {
        foreach ($networks as $index => $network) {
            $newOrder[$index] = collect($this->footer['networks'])->where('id', $network['value'])->first();
        }

        $this->footer['networks'] = $newOrder;

        return $this->save();
    }

    public function updateFooter($data)
    {
        $this->footer = $data;

        return $this->save();
    }

    private function settings(): GeneralSettings
    {
        return app(GeneralSettings::class);
    }
}
