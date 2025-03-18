<?php

namespace LaraZeus\Tartarus\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaraZeus\Tartarus\Scopes\CompanyScope;
use LaraZeus\Tartarus\TartarusPlugin;

trait ForCompany
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(TartarusPlugin::getModel('Company'));
    }

    public static function bootForCompany(): void
    {
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $model->setAttribute('company_id', tenant('id'));
            $model->setRelation('company', tenant());
        });
    }
}
