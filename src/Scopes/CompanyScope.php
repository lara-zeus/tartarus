<?php

namespace LaraZeus\Tartarus\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * @method static Builder<static> withoutCompany()
 */
class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->qualifyColumn('company_id'), tenant('id'));
    }

    public function extend(Builder $builder): void
    {
        $builder->macro('withoutCompany', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
