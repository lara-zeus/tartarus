<?php

namespace App\Models;

use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;
use LaraZeus\Tartarus\Scopes\CompanyAndLandlordScope;
use Spatie\Translatable\HasTranslations;

class Role extends \Spatie\Permission\Models\Role
{
    use ChaosModel;
    use ForCompany;
    use HasTranslations;

    public array $translatable = ['name'];

    public static function bootForCompany(): void
    {
        static::addGlobalScope(new CompanyAndLandlordScope());

        static::creating(function ($model) {
            $model->setAttribute('company_id', tenant('id'));
            $model->setRelation('company', tenant());
        });
    }
}
