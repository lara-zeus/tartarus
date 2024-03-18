<?php

namespace LaraZeus\Tartarus\Models\Concerns;

use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ForFilament
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;

        /*if ($panel->getId() === 'admin') {
            return $this->email === 'note@note.note';
        }

        return true;*/
    }

    public function getTenants(Panel $panel): array | Collection
    {
        return $this->allCompanies();
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->currentCompany;
    }

    public function getFilamentAvatarUrl(): string
    {
        return $this->avatar;
    }
}
