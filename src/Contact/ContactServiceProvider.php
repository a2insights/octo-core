<?php
namespace Octo\Contact;

use Filament\PluginServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Octo\Contact\Filament\ContactResource;
use Octo\Contact\Models\Contact;
use Spatie\LaravelPackageTools\Package;

class ContactServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        ContactResource::class,
    ];

    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        parent::register();

        AliasLoader::getInstance()->alias('Contact\Contact', Facade::class);

        App::bind('Contact', function () {
            return app(Contact::class);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.common');
    }
}
