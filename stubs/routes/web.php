<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    //include 'local.php';
}

Route::domain('{domain}.' . config('zeus-tartarus.central_domain'))
    ->get('/a', function () {
        dd(9);
    })
    ->name('tenant.home');

Route::view('/', 'site.home');

Route::post('logout', function (Request $request) {
    auth()->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
})
    ->name('logout');

Route::get('lang/{lang}', function ($lang) {
    if (array_key_exists($lang, config('app.locales'))) {
        session()->put('current_lang', $lang);
    } else {
        session()->put('current_lang', 'ar');
    }

    return redirect(url()->previousPath());
});
