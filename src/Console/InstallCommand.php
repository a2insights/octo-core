<?php

namespace Octo\Console;

use Illuminate\Console\Command;
use Octo\Concerns\HasSmsProviderConfig;
use Octo\Concerns\InteractWithComposer;

class InstallCommand extends Command
{
    use InteractWithComposer;

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
    protected $description = 'Install the octo';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("\nOcto Installer");
        $this->info("--------------------\n");

    }
}
