<?php

namespace Octo\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'octo:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the octo blade and resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("\nOcto Installer");
        $this->info("--------------------\n");

        $this->maybeGenerateAppKey();

        // Publish vendor assets
        $this->call('vendor:publish', ['--tag' => 'livewire-ui:public', '--force']);
        $this->call('vendor:publish', ['--tag' => 'public', '--provider' => 'LaravelViews\LaravelViewsServiceProvider', '--force']);

        $this->callSilent('vendor:publish', ['--tag' => 'octo-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'octo-migrations', '--force' => true]);

        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Fortify'));

        copy(__DIR__ . '/../../stubs/app/Actions/Fortify/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));

        $this->info('✅ Everything succeeded ✅');
    }

    private function maybeGenerateAppKey(): void
    {
        if (!config('app.key')) {
            $this->info('Generating app key');
            $this->call('key:generate');
        } else {
            $this->comment('App key exists -- skipping');
        }
    }
}
