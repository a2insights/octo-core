<?php

namespace Octo;

use Octo\Settings\GeneralSettings;

class Site
{
    public static function getName(): string
    {
        return self::setting()->site_name;
    }

    public static function getActive(): bool
    {
        return self::setting()->site_active;
    }

    public static function getDescription(): string
    {
        return self::setting()->site_description;
    }

    public static function update($data)
    {
        $settings = self::setting();

        $settings->site_name = $data['name'];
        $settings->site_active = $data['active'];
        $settings->site_description = $data['description'];

        return $settings->save();
    }

    private static function setting(): GeneralSettings
    {
        return app(GeneralSettings::class);
    }
}
