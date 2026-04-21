<?php

use LaraZeus\Tartarus\Models\Company;
use LaraZeus\Tartarus\Models\ConnectedAccount;
use LaraZeus\Tartarus\Models\Employeeship;
use LaraZeus\Tartarus\Models\Settings;
use LaraZeus\Tartarus\Models\SoftDelete;
use LaraZeus\Tartarus\Models\Tag;

return [
    'central_domain' => env('CENTRAL_DOMAIN', ''),

    'delete-before-date' => '2022-01-01',

    'models' => [
        'Company' => Company::class,
        'ConnectedAccount' => ConnectedAccount::class,
        'Employeeship' => Employeeship::class,
        'Settings' => Settings::class,
        'SoftDelete' => SoftDelete::class,
        'Tag' => Tag::class,
    ],
];
