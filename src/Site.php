<?php

namespace Octo;

use Octo\Settings\GeneralSettings;

class Site extends ObjectPrototype
{
    public static function getName(): string
    {
        return self::settings()->site_name;
    }

    public static function getActive(): bool
    {
        return self::settings()->site_active;
    }

    public static function getDescription(): string
    {
        return self::settings()->site_description;
    }

    public static function update($data)
    {
        $settings = self::settings();

        $settings->site_name = $data['name'];
        $settings->site_active = $data['active'];
        $settings->site_description = $data['description'];

        return $settings->save();
    }

    public static function sections()
    {
        return self::settings()->site_sections;
    }

    public static function saveSection($section)
    {
        if (! @$section['id']) {
           return self::addSection($section);
        }

        return self::updateSection($section);
    }

    public static function updateSection($data)
    {
        $settings = self::settings();

        foreach($settings->site_sections as $key => $section) {
            if ($section['id'] === $data['id']) {
                $settings->site_sections[$key]['name'] = $data['name'];
                $settings->site_sections[$key]['content'] = $data['content'];
                $settings->site_sections[$key]['image_path'] = $data['image_path'];
                $settings->site_sections[$key]['image_url'] = $data['image_url'];
                break;
            }
        }

        return $settings->save();
    }

    public static function deleteSection($id)
    {
        $settings = self::settings();

        foreach($settings->site_sections as $key => $section) {
            if ($section['id'] === $id) {
                unset($settings->site_sections[$key]);
                break;
            }
        }

       return $settings->save();
    }

    public static function addSection($data)
    {
        $settings = self::settings();

        $data = (new Section([
            'name'       => $data['name'],
            'content'    => $data['content'],
            'image_url'  => $data['image_url'],
            'image_path' => $data['image_path'],
        ]))->toArray();

        $sections = $settings->site_sections;

        array_push($sections, $data);

        $settings->site_sections = $sections;

        return $settings->save();
    }

    public static function updateSectionsOrder($sections)
    {
        $settings = self::settings();

        $newSections = [];

        foreach($sections as $index => $section) {

            $sectionSaved = collect($settings->site_sections)->where('id', $section['value'])->first();

            $newSections[$index] = [
                'id'         => $sectionSaved['id'],
                'name'       => $sectionSaved['name'],
                'content'    => $sectionSaved['content'],
                'image_path' => $sectionSaved['image_path'] ?? null,
                'image_url'  => $sectionSaved['image_url'] ?? null,
            ];
        }

        $settings->site_sections = $newSections;

       return $settings->save();
    }

    private static function settings(): GeneralSettings
    {
        return app(GeneralSettings::class);
    }
}
