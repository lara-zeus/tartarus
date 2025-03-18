<?php

namespace LaraZeus\Tartarus\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use LaraZeus\Tartarus\Models\Company;
use LaraZeus\Tartarus\TartarusPlugin;

trait HasCompanies
{
    public function isCurrentCompany(Company $company): bool
    {
        return $company->id === $this->currentCompany->id;
    }

    public function currentCompany(): BelongsTo
    {
        $this->switchCompany(tenant());

        return $this->belongsTo(TartarusPlugin::getModel('Company'), 'current_company_id');
    }

    public function switchCompany(?Company $company = null): bool
    {
        if (! $this->belongsToCompany($company)) {
            return false;
        }

        $this->forceFill([
            'current_company_id' => $company->id,
        ])->save();

        $this->setRelation('currentCompany', $company);

        return true;
    }

    public function allCompanies(): Collection
    {
        return $this->ownedCompanies->merge($this->companies)->sortBy('name');
    }

    public function ownedCompanies(): HasMany
    {
        return $this->hasMany(TartarusPlugin::getModel('Company'));
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(TartarusPlugin::getModel('Company'), TartarusPlugin::getModel('Employeeship'))
            ->withPivot('role')
            ->withTimestamps()
            ->as('employeeship');
    }

    public function ownsCompany(?Model $company = null): bool
    {
        if ($company === null) {
            return false;
        }

        return $this->id === $company->{$this->getForeignKey()};
    }

    public function belongsToCompany(null | Company | Model $company = null): bool
    {
        if ($company === null) {
            return false;
        }

        return $this->ownsCompany($company) || $this->companies->contains(static function ($t) use ($company) {
            return $t->id === $company->id;
        });
    }
}
