<?php

namespace LaraZeus\Tartarus\Middleware;

use Closure;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var \LaraZeus\Tartarus\Models\Company $tenant
         */
        $tenant = tenant();

        if ($tenant !== null) {

            $this->setPanelConfiguration($tenant);

            /** @phpstan-ignore-next-line */
            if ($tenant?->id !== getPermissionsTeamId()) {
                /** @phpstan-ignore-next-line */
                setPermissionsTeamId($tenant?->id);
            }
        }

        return $next($request);
    }

    private function setPanelConfiguration(Model $tenant): void
    {
        $colorName = str($tenant->primary_color ?? 'Blue')->title();
        $color = constant("Filament\Support\Colors\Color::$colorName");
        FilamentColor::register([
            'primary' => $color,
            'secondary' => Color::Amber,
            'danger' => Color::Red,
            'info' => Color::Blue,
            'success' => Color::Green,
            'warning' => Color::Yellow,
        ]);
    }
}
