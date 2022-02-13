<?php

namespace Octo;

class Octo
{
    public static function site(): Site
    {
        return app(Site::class);
    }
}
