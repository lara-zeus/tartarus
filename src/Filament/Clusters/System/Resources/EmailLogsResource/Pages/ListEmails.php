<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource\Pages;

use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosListRecords;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource;

class ListEmails extends ChaosListRecords
{
    protected static string $resource = EmailLogsResource::class;
}
