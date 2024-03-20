<!DOCTYPE html>
<html dir="{{ (app()->getLocale() === 'ar') ? 'rtl' : 'ltr' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Note</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @filamentStyles
    @vite(['resources/css/site/site.css'])
    @stack('styles')
</head>
<body class="antialiased">

<div class="relative">
    <div class="absolute ltr:left-10 rtl:right-10 top-10">
        <x-lang/>
    </div>
</div>

<div class="w-full flex flex-col gap-4 justify-center items-center min-h-screen bg-center bg-gray-50 selection:bg-primary-500 selection:text-white">
    <div class="flex gap-4 justify-center items-center">
        <img data-aos="zoom-in" class="w-52" alt="Form فورمة - نماذج احترافية لأعمالك" src="{{ asset('images/logo.png') }}">
        <div data-aos="zoom-in" class="-space-y-1 rtl:space-y-1">
            <p class="font-semibold ltr:text-left rtl:text-right text-5xl text-primary-600 px-1">
                <x-base.app-name/>
            </p>
            <p class="pt-4 font-semibold ltr:text-right rtl:text-left text-3xl text-primary-600 px-1">{{ __('app.title_2') }}</p>
            <p class="font-semibold ltr:text-right rtl:text-left text-3xl text-secondary-600 px-1">{{ __('app.title_3') }}</p>
            <p class="italic ltr:text-right rtl:text-left text-2xl text-warning-600 px-1">{{ __('app.title_4') }}</p>
            <div class="ltr:text-right rtl:text-left text-3xl text-info-600 px-1">
                <div class="rtl:text-left ltr:text-right w-full">
                    <div class="content__container">
                        <ul class="content__container__list">
                            <li class="content__container__list__item">{{ __('app.Business') }}</li>
                            <li class="content__container__list__item">{{ __('app.Company') }}</li>
                            <li class="content__container__list__item">{{ __('app.Project') }}</li>
                            <li class="content__container__list__item">{{ __('app.School') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        <x-filament::button
                icon="tabler-info-circle-filled"
                tag="a"
                :href="url('admin')"
        >
            {{ __('as admin') }}
        </x-filament::button>

        <x-filament::button
                icon="tabler-info-circle-filled"
                tag="a"
                :href="url('app')"
        >
            {{ __('as org owner') }}
        </x-filament::button>
    </div>

</div>


@stack('scripts')
@filamentScripts
@livewire('notifications')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@if(app()->isProduction())
    <script async src="https://stats.still-code.com/script.js" data-website-id="b5f9362c-8720-46bf-9083-95d0b16788f7"></script>
@endif
</body>
</html>