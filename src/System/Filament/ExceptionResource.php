<?php

namespace A2Insights\FilamentSaas\System\Filament;

use BezhanSalleh\FilamentExceptions\Resources\ExceptionResource as ResourcesExceptionResource;

class ExceptionResource extends ResourcesExceptionResource
{
    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }
}
