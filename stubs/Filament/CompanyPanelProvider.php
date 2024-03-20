<?php

namespace App\Providers\Filament;

use Filament\Forms\Components\FileUpload;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use LaraZeus\Erebus\ErebusPlugin;
use LaraZeus\Tartarus\Filament\Pages\RegisterCompany;
use LaraZeus\Tartarus\Filament\Pages\Settings;
use LaraZeus\Tartarus\Models\Company;
use LaraZeus\Tartarus\Providers\FilamentPanelProvider;

class CompanyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return FilamentPanelProvider::panel($panel)
            ->default()
            ->id('company')
            ->path('app')
            ->homeUrl(static fn (): string => url('/'))
            // auth
            ->login()
            ->registration()
            ->passwordReset()

            //
            ->tenant(Company::class, 'subdomain')
            ->tenantProfile(Settings::class)
            ->tenantRegistration(RegisterCompany::class)

            ->discoverResources(in: app_path('Filament/Company/Resources'), for: 'App\\Filament\\Company\\Resources')
            ->discoverPages(in: app_path('Filament/Company/Pages'), for: 'App\\Filament\\Company\\Pages')
            ->discoverWidgets(in: app_path('Filament/Company/Widgets'), for: 'App\\Filament\\Company\\Widgets')
            ->discoverClusters(in: app_path('Filament/Company/Clusters'), for: 'App\\Filament\\Company\\Clusters')
            //
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->tenantMiddleware([
                \LaraZeus\Tartarus\Middleware\SetTenant::class,
            ], isPersistent: true)
            ->plugins([
                ErebusPlugin::make(),
                BreezyCore::make()
                    ->avatarUploadComponent(
                        fn () => FileUpload::make('profile_photo_path')
                            ->label(__('Profile photo'))
                            ->image()
                            ->disk('gcs')
                            ->imageEditor()
                            ->directory('user_profile_photo')
                    )
                    ->myProfile(shouldRegisterUserMenu: false, hasAvatars: true)
                    ->enableTwoFactorAuthentication(),
            ]);
    }
}
