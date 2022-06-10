<?php

namespace Octo\Console;

use Illuminate\Console\Command;
use Octo\Console\Concerns\InteractWithComposer;

class ComposerCommand extends Command
{
    use InteractWithComposer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'octo:composer {instructions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Composer command';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("\nComposer Command");
        $this->info("--------------------\n");

        $this->composer(explode('|', $this->argument('instructions')));
    }
}
