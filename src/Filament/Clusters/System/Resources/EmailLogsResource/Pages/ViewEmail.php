<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource\Pages;

use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosViewRecord;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource;

class ViewEmail extends ChaosViewRecord
{
    protected static string $resource = EmailLogsResource::class;
}
