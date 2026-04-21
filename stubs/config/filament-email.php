<?php

use App\Models\Email;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource;

return [

    'resource' => [
        'class' => EmailLogsResource::class,
        'model' => Email::class,
        'group' => null,
        'sort' => null,
        'default_sort_column' => 'created_at',
        'default_sort_direction' => 'desc',
    ],

    'keep_email_for_days' => 9960,
    'label' => null,
];
