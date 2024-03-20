<?php

namespace LaraZeus\Tartarus\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    protected $signature = 'tartarus:install';

    protected $description = 'install tartarus plugin';

    public function handle(): void
    {
        $this->info('publishing zeus config...');
        $this->call('vendor:publish', ['--tag' => 'zeus-tartarus-config']);

        $this->info('publishing migration...');
        $this->call('vendor:publish', ['--tag' => 'zeus-tartarus-migrations']);
        $this->call('vendor:publish', ['--tag' => 'zeus-erebus-migrations']);

        $this->info('publishing stubs files...');

        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/css', resource_path('/css'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/views', resource_path('/views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/routes', base_path('/routes'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/config', base_path('/config'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/Filament', app_path('/Providers/Filament'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/seeders', base_path('/database/seeders'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/Models', app_path('/Models'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/AppServiceProvider.php', app_path('/Providers/AppServiceProvider.php'));

        $this->registerPnaelProviders();

        $this->output->success('Zeus Tartarus has been Installed successfully, consider ⭐️ the package in filament site :)');
    }

    private function registerPnaelProviders(): void
    {
        $isLaravel11OrHigherWithBootstrapProvidersFile = version_compare(App::version(), '11.0', '>=') &&
            /** @phpstan-ignore-next-line */
            file_exists($bootstrapProvidersPath = App::getBootstrapProvidersPath());

        foreach (['AdminPanelProvider','CompanyPanelProvider'] as $item) {
            if ($isLaravel11OrHigherWithBootstrapProvidersFile) {
                /** @phpstan-ignore-next-line */
                ServiceProvider::addProviderToBootstrapFile(
                    "App\\Providers\\Filament\\".$item,
                    /** @phpstan-ignore-next-line */
                    $bootstrapProvidersPath,
                );
            } else {
                $appConfig = file_get_contents(config_path('app.php'));

                if (! Str::contains($appConfig, "App\\Providers\\Filament\\AdminPanelProvider}::class")) {
                    file_put_contents(config_path('app.php'), str_replace(
                        'App\\Providers\\RouteServiceProvider::class,',
                        "App\\Providers\\Filament\\{$item}::class," . PHP_EOL . '        App\\Providers\\RouteServiceProvider::class,',
                        $appConfig,
                    ));
                }
            }
        }
    }
}
