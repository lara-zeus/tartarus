<?php

namespace LaraZeus\Tartarus\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaraZeus\Tartarus\Models\CompanyInvitation;
use LaraZeus\Tartarus\Models\Employeeship;
use LaraZeus\Tartarus\Models\Settings;

trait CompanyRelations
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    public function companyInvitations(): HasMany
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model'), Employeeship::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('employeeship');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(config('permission.models.role'));
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Settings::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(config('tags.tag_model'));
    }
}
