<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\TagResource\Pages;

use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosListRecords;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\TagResource;

class ListTags extends ChaosListRecords
{
    protected static string $resource = TagResource::class;
}
