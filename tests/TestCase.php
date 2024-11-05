<?php

namespace A2insights\FilamentSaas\Tests;

use A2insights\FilamentSaas\FilamentSaasServiceProvider;
use A2insights\FilamentSaas\User\Filament\Components\Phone;
use A2insights\FilamentSaas\User\Filament\Components\Username;
use A2insights\FilamentSaas\User\Filament\Pages\BannedUser;
use A2insights\FilamentSaas\User\Filament\Pages\Register;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'A2insights\\FilamentSaas\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->registerLivewireComponents();
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentSaasServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('filament-webhook-server.models', []); // Disable webhooks

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-saas_table.php.stub';
        $migration->up();
        */
    }

    private function registerLivewireComponents(): self
    {
        Livewire::component('BannedUser', BannedUser::class);
        Livewire::component('Register', Register::class);
        Livewire::component('phone', Phone::class);
        Livewire::component('username', Username::class);

        return $this;
    }
}
