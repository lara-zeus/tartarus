<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Company;
use LaraZeus\Tartarus\Models\Concerns\ForFilament;
use LaraZeus\Tartarus\Models\Concerns\HasCompanies;
use LaraZeus\Tartarus\Models\ConnectedAccount;
use LaraZeus\Tartarus\Models\Employeeship;
use Rinvex\Subscriptions\Traits\HasPlanSubscriptions;
use Spatie\Color\Rgb;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

/**
 * @property ?Company $currentCompany
 * @property string $profile_photo_path
 * @property string $avatar
 * @property Collection $companies
 * @property Collection $ownedCompanies
 * @property int $id
 * @property Role $roles
 */
class User extends Authenticatable implements FilamentUser, HasAvatar, HasDefaultTenant, HasTenants
{
    use ChaosModel;
    use ForFilament;
    use HasCompanies;

    /*use HasPlanSubscriptions;*/
    use HasRoles;
    use HasTranslations;
    use TwoFactorAuthenticatable;

    public array $translatable = ['zname'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* *
     * @var Company $tenant
     */
    public function canAccessTenant(Model | Company $tenant): bool
    {
        return $this->belongsToCompany($tenant);
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn (
            ) => ($this->profile_photo_path !== null) ? Storage::url($this->profile_photo_path) : $this->defaultProfilePhotoUrl(),
        );
    }

    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(static function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        $bgColor = '0284c7';
        if (tenant() !== null) {
            $colorName = str(tenant()?->primary_color ?? 'Blue')->title();
            $color = constant("Filament\Support\Colors\Color::$colorName");
            $bgColor = str(Rgb::fromString('rgb(' . $color[500] . ')')->toHex())->replace('#', '') ?? $bgColor;
        }

        return sprintf('https://ui-avatars.com/api/?name=%s&color=fff&background=' . $bgColor, urlencode($name));
    }

    public function ConnectedAccounts(): HasMany
    {
        return $this->hasMany(ConnectedAccount::class);
    }

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, Employeeship::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('employeeship');
    }

    // todo
    public function canImpersonate(): bool
    {
        return true;
    }

    public function canBeImpersonated(): bool
    {
        return true;
    }
}
