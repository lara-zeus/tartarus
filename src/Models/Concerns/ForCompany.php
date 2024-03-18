<?php

namespace LaraZeus\Tartarus\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaraZeus\Tartarus\Models\Company;
use LaraZeus\Tartarus\Scopes\CompanyScope;

trait ForCompany
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public static function bootForCompany(): void
    {
        static::addGlobalScope(new CompanyScope());

        static::creating(function ($model) {
            $model->setAttribute('company_id', tenant('id'));
            $model->setRelation('company', tenant());
        });
    }
}
