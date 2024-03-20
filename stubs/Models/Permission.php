<?php

namespace App\Models;

use LaraZeus\Chaos\Concerns\ChaosModel;
use Spatie\Translatable\HasTranslations;

class Permission extends \Spatie\Permission\Models\Permission
{
    use ChaosModel;
    use HasTranslations;

    public array $translatable = ['name'];
}
