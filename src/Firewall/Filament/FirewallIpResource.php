<?php

namespace Octo\Firewall\Filament;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource as BaseFirewallIpResource;

class FirewallIpResource extends BaseFirewallIpResource
{
    // use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-users';
}
