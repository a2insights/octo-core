<?php

namespace Octo;

use Octo\Settings\GeneralSettings;

class Site extends ObjectPrototype
{
    protected $attributes = [
        'name', 'active', 'description',
        'footer' => [['links' => [], 'networks' => []]],
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
        foreach($this->sections as $key => $section) {
            if ($section['id'] === $data['id']) {
                $this->sections[$key] = $data;
                break;
            }
        }

        return $this->save();
    }

    public function deleteSection($id)
    {
        foreach($this->sections as $key => $section) {
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
        foreach($sections as $index => $section) {
            $newOrder[$index] = collect($this->sections)->where('id', $section['value'])->first();
        }

        $this->sections = $newOrder;

        return $this->save();
    }

    private function settings(): GeneralSettings
    {
        return app(GeneralSettings::class);
    }
}
