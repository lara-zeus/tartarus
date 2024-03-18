<?php

namespace LaraZeus\Tartarus\Models;

use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\CompanyRelations;
use Spatie\Color\Rgb;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $logo
 * @property string $subdomain
 * @property string $primary_color
 * @property string $name
 * @property \App\Models\User $users
 * @property Settings $settings
 * @property \App\Models\User $owner
 */
class Company extends Model implements HasAvatar, HasCurrentTenantLabel, HasName
{
    use ChaosModel;
    use CompanyRelations;
    use HasTranslations;

    public array $translatable = ['name'];

    public function saveCompanySettings(array $data): void
    {
        foreach (\LaraZeus\Tartarus\Settings\Company::settings() as $setting) {
            if (isset($data[$setting])) {
                /** @phpstan-ignore-next-line */
                $this
                    ->settings()
                    ->withoutCompany()
                    ->updateOrInsert(
                        [
                            'name' => $setting,
                            'company_id' => $this->id,
                        ],
                        [
                            'payload' => $data[$setting] ?? '-',
                        ]
                    );
            }
        }
    }

    public function allUsers(): Collection
    {
        // @phpstan-ignore-next-line
        return $this->users->merge([$this->owner]);
    }

    public function hasUser(Model $user): bool
    {
        /** @phpstan-ignore-next-line */
        return $this->users->contains($user) || $user->ownsCompany($this);
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(static function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function removeUser(mixed $user): void
    {
        if ($user->current_company_id === $this->id) {
            $user->forceFill([
                'current_company_id' => null,
            ])->save();
        }

        $this->users()->detach($user);
    }

    public function purge(): void
    {
        $this->owner()->where('current_company_id', $this->id)
            ->update(['current_company_id' => null]);

        $this->users()->where('current_company_id', $this->id)
            ->update(['current_company_id' => null]);

        $this->users()->detach();

        $this->delete();
    }

    public function getFilamentAvatarUrl(): string
    {
        if ($this->logo !== null) {
            /** @phpstan-ignore-next-line */
            $logo = Media::query()
                ->withoutCompany()
                ->find($this->logo)
                ?->path;
            if ($logo !== null) {
                return Storage::url($logo);
            }
        }

        return $this->defaultProfilePhotoUrl();
    }

    public function getCurrentTenantLabel(): string
    {
        return __('Active Company');
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(static function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        $colorName = str(tenant()->primary_color ?? 'Blue')->title();
        $color = constant("Filament\Support\Colors\Color::$colorName");
        $bgColor = str(Rgb::fromString('rgb(' . $color[500] . ')')->toHex())->replace('#', '');

        return sprintf('https://ui-avatars.com/api/?name=%s&color=FFFFFF&background=' . $bgColor, urlencode($name));
    }

    protected function fullUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://' . $this->subdomain . '.' . config('note.central_domain'),
        );
    }
}
