<?php

namespace Octo\System\Filament;

use Z3d0X\FilamentLogger\Resources\ActivityResource;

class LoggerResource extends ActivityResource
{
    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }
}
