<?php

use Illuminate\Support\Facades\Route;

Route::get('lang/{lang}', function ($lang) {
    if (array_key_exists($lang, config('app.locales'))) {
        session()->put('current_lang', $lang);
    } else {
        session()->put('current_lang', 'ar');
    }

    return redirect(url()->previousPath());
});
