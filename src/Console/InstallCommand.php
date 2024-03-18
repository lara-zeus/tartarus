<?php

namespace LaraZeus\Tartarus\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'tartarus:install';

    protected $description = 'install tartarus plugin';

    public function handle(): void
    {
        $this->info('publishing subscriptions ...');
        $this->call('rinvex:publish:subscriptions');

        $this->info('publishing zeus config...');
        $this->call('vendor:publish', ['--tag' => 'zeus-tartarus-config']);
        $this->call('vendor:publish', ['--tag' => 'zeus-config']);

        $this->info('publishing zeus assets...');
        $this->call('vendor:publish', ['--tag' => 'zeus-assets']);

        $this->output->success('Zeus Tartarus has been Installed successfully, consider ⭐️ the package in filament site :)');
    }
}
