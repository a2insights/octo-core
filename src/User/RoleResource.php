<?php

namespace Octo\User;

use BezhanSalleh\FilamentShield\Resources\RoleResource as ResourcesRoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;

class RoleResource extends ResourcesRoleResource
{
    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? 'Users'
            : '';
    }
}
