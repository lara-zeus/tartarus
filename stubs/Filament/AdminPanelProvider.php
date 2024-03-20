<?php

namespace App\Providers\Filament;

use Filament\Forms\Components\FileUpload;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use LaraZeus\Erebus\ErebusPlugin;
use LaraZeus\Tartarus\Middleware\SetTenant;
use LaraZeus\Tartarus\Providers\FilamentPanelProvider;
use LaraZeus\Tartarus\TartarusPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return FilamentPanelProvider::panel($panel)
            ->id('admin')
            ->path('admin')
            ->homeUrl('/')

            // auth
            ->login()

            // plugins
            ->plugins([
                ErebusPlugin::make(),
                TartarusPlugin::make(),
                BreezyCore::make()
                    ->avatarUploadComponent(
                        fn () => FileUpload::make('profile_photo_path')
                            ->label(__('Profile photo'))
                            ->image()
                            ->disk('arc')
                            ->imageEditor()
                            ->directory('user_profile_photo')
                    )
                    ->myProfile(shouldRegisterUserMenu: false, hasAvatars: true)
                    ->enableTwoFactorAuthentication(),
            ])

            // discover
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\\Filament\\Admin\\Clusters')

            //
            ->middleware([
                SetTenant::class,
            ])
            // default page and widget
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
            ]);
    }
}
