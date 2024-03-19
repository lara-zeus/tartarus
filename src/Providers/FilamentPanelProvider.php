<?php

namespace LaraZeus\Tartarus\Providers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use LaraZeus\Erebus\Filament\Clusters\Employees\Resources\NotificationResource;
use LaraZeus\Erebus\Filament\Pages\UserProfile;
use LaraZeus\Tartarus\Middleware\SetLang;
use Livewire\Livewire;

class FilamentPanelProvider
{
    public static function panel(Panel $panel): Panel
    {
        self::configuringColumns();
        self::configuringComponents();

        FilamentIcon::register([
            'panels::sidebar.collapse-button' => 'tabler-layout-sidebar-right-collapse-filled',
            'panels::sidebar.expand-button' => 'tabler-layout-sidebar-left-collapse-filled',
            'panels::pages.dashboard.navigation-item' => 'tabler-home',
        ]);

        return $panel
            //->sidebarWidth('200px')
            //->brandLogoHeight('3rem')

            ->renderHook(
                'panels::footer',
                fn (): View => view('zeus-tartarus::hooks.footer'),
            )

            ->brandLogo(fn () => view('zeus-tartarus::hooks.filament-logo'))
            ->favicon(asset('favicon/favicon.ico'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()

            // plugins
            ->plugins([
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(config('app.locales')),
            ])

            // misc
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->renderHook('panels::user-menu.profile.after', fn (): View => view('zeus-tartarus::hooks.user-menu-lang'))

            // nav
            ->userMenuItems([
                MenuItem::make()
                    ->visible(fn () => tenant() !== null)
                    ->label(fn () => __('My Profile'))
                    ->icon('heroicon-o-user-circle')
                    ->url(static fn () => UserProfile::getUrl()),

                // wtf, error in register
                MenuItem::make()
                    ->visible(fn () => tenant() !== null)
                    ->label(fn () => __('All Notifications'))
                    ->icon('tabler-bell')
                    ->url(static fn () => NotificationResource::getUrl(tenant: tenant())),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLang::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public static function configuringColumns(): void
    {
        Table::$defaultDateTimeDisplayFormat = 'Y/m/d - h:i A';
        Table::$defaultDateDisplayFormat = 'Y/m/d';

        Column::configureUsing(function (Column $column) {
            $column
                ->searchable()
                ->sortable()
                ->label(fn () => __(self::getLangFile() . $column->getName()))
                ->toggleable();
        });

        ImageColumn::configureUsing(function (ImageColumn $column) {
            $column->label(fn () => __(self::getLangFile() . $column->getName()));
        });
    }

    public static function configuringComponents(): void
    {
        Field::configureUsing(function (Field $column) {
            $column->label(fn () => __(self::getLangFile() . $column->getName()));
        });

        Select::configureUsing(function (Select $field) {
            $field
                ->searchable()
                ->preload();
        });
    }

    public static function getLangFile(): string
    {
        if (
            method_exists(Livewire::current(), 'getResource')
            && method_exists(Livewire::current()->getResource(), 'langFile')
        ) {
            /** @phpstan-ignore-next-line */
            return Livewire::current()->getResource()::langFile() . '.';
        }

        return '';
    }
}
