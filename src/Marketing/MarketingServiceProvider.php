<?php
namespace Octo\Marketing;

use Filament\PluginServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Octo\Marketing\Models\Campaign;
use Octo\Marketing\Facades\Campaign as FacadesCampaign;
use Octo\Marketing\Facades\CampaignTarget as FacadesCampaignTarget;
use Octo\Marketing\Facades\Contact as FacadesContact;
use Octo\Marketing\Filament\Campaign\CampaignResource;
use Octo\Marketing\Filament\Contact\ContactResource;
use Octo\Marketing\Models\CampaignTarget;
use Octo\Marketing\Models\Contact;
use Spatie\LaravelPackageTools\Package;

class MarketingServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        ContactResource::class,
        CampaignResource::class,
    ];

    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
    }

    public function register()
    {
        parent::register();

        AliasLoader::getInstance()->alias('Marketing\Contact', FacadesContact::class);
        AliasLoader::getInstance()->alias('Marketing\Campaign', FacadesCampaign::class);
        AliasLoader::getInstance()->alias('Marketing\CampaignTarget', FacadesCampaignTarget::class);

        App::bind('Contact', function () {
            return app(Contact::class);
        });

        App::bind('Campaign', function () {
            return app(Campaign::class);
        });

        App::bind('CampaignTarget', function () {
            return app(CampaignTarget::class);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.marketing');
    }
}
