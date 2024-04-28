<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /*Gate::before(function (User $user, string $ability) {
            return $user->id === 1;
        });*/

        Number::useLocale('en');
        URL::defaults(['domain' => '']);
        if (!$this->app->isLocal()) {
            URL::forceScheme('https');
        }
        Model::unguard();
    }
}
