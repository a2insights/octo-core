<?php
namespace Octo\Contact;

use Filament\PluginServiceProvider;
use Octo\Contact\Filament\ContactResource;
use Spatie\LaravelPackageTools\Package;

class ContactServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        ContactResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo.common');
    }
}
