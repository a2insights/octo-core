<?php

namespace Octo;

use Octo\Settings\SiteSettings;

class Octo
{
    public static function site(): SiteSettings
    {
        return app(SiteSettings::class);
    }
}
