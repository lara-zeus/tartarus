<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Finder;

Route::get('langger', function () {
    foreach (load(app_path('Filament')) as $item) {
        if (str($item)->endsWith('Resource')) {
            $f = str($item::getSlug())->explode('/')->last();

            if (! file_exists(lang_path('ar/' . $f . '.php'))) {
                file_put_contents(lang_path('ar/' . $f . '.php'), "<?php
return [
    'title' => '{$item::getSlug()}',
    'titleSingle' => '{$item::getSlug()}',
];");
            }
        }
    }
});

function load($path): array
{
    $classes = [];
    foreach ((new Finder)->in($path)->files() as $className) {
        $classes[] = 'App\\'
            . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($className->getPathname(), app_path('/'))
            );
    }

    return $classes;
}
