<?php

namespace Octo\Console;

use Illuminate\Console\Command;
use Octo\Console\Concerns\InteractWithComposer;

class InstallAddonCommand extends Command
{
    use InteractWithComposer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'octo:addon-install {composer_command} {composer_json_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the octo addon feature';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("\nOcto Addon Installer");
        $this->info("--------------------\n");

        $this->composer($this->argument('composer_command'), $this->argument('composer_json_path'));
    }
}
