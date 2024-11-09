<?php

namespace A2Insights\FilamentSaas\Tests;

use A2Insights\FilamentSaas\FilamentSaasServiceProvider;
use A2Insights\FilamentSaas\User\Filament\Components\Phone;
use A2Insights\FilamentSaas\User\Filament\Components\Username;
use A2Insights\FilamentSaas\User\Filament\Pages\BannedUser;
use A2Insights\FilamentSaas\User\Filament\Pages\Register;
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
            fn (string $modelName) => 'A2Insights\\FilamentSaas\\Database\\Factories\\'.class_basename($modelName).'Factory'
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
