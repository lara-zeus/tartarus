<?php

return [

    'resource' => [
        'class' => \LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource::class,
        'model' => \App\Models\Email::class,
        'group' => null,
        'sort' => null,
        'default_sort_column' => 'created_at',
        'default_sort_direction' => 'desc',
    ],

    'keep_email_for_days' => 9960,
    'label' => null,
];
