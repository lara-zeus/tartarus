<?php

namespace LaraZeus\Tartarus\Filament\Clusters;

use Filament\Clusters\Cluster;

class System extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationLabel(): string
    {
        return __('app.System_cluster');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return __('app.System_cluster');
    }
}
