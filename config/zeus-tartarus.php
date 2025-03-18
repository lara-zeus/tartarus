<?php

return [
    'central_domain' => env('CENTRAL_DOMAIN', ''),

    'delete-before-date' => '2022-01-01',

    'models' => [
        'Company' => \LaraZeus\Tartarus\Models\Company::class,
        'ConnectedAccount' => \LaraZeus\Tartarus\Models\ConnectedAccount::class,
        'Employeeship' => \LaraZeus\Tartarus\Models\Employeeship::class,
        'Settings' => \LaraZeus\Tartarus\Models\Settings::class,
        'SoftDelete' => \LaraZeus\Tartarus\Models\SoftDelete::class,
        'Tag' => \LaraZeus\Tartarus\Models\Tag::class,
    ],
];
