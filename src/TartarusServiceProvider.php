<?php

namespace LaraZeus\Tartarus;

use LaraZeus\Tartarus\Console\InstallCommand;
use LaraZeus\Tartarus\Filament\Pages\RegisterCompany;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TartarusServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-tartarus';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations($this->getMigrations())
            ->hasCommands([
                InstallCommand::class,
            ])
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Livewire::component('register-company', RegisterCompany::class);
    }

    protected function getMigrations(): array
    {
        return [
            'create_companies_table',
            'create_company_user_table',
            'create_filament_email_table',
            'create_settings_table',
            'create_tag_tables',
        ];
    }
}
