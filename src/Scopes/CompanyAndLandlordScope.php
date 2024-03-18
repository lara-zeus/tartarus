<?php

namespace LaraZeus\Tartarus\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyAndLandlordScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder
            ->where($model->qualifyColumn('company_id'), tenant('id'))
            ->orWhere($model->qualifyColumn('company_id'), null);
    }
}
