<?php

namespace LaraZeus\Tartarus;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\Tartarus\Filament\Pages\Deleter;

final class TartarusPlugin implements Plugin
{
    use Configuration;
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'zeus-tartarus';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverClusters(in: __DIR__ . '/Filament/Clusters', for: 'LaraZeus\\Tartarus\\Filament\\Clusters')
            ->pages([
                Deleter::class,
            ])
            ->resources([
                //
            ]);
    }

    public static function make(): static
    {
        return new self();
    }

    public static function get(): static
    {
        // @phpstan-ignore-next-line
        return filament('zeus-tartarus');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
