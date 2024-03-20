@if(app('impersonate')->isImpersonating())
    @php
        $display = $display ?? Filament\Facades\Filament::getUserName(Filament\Facades\Filament::auth()->user());
    @endphp

    <div class="bg-danger-50 rounded-lg shadow-sm px-2 py-1 ring-1 ring-danger-100 flex gap-2 items-center justify-start">
        <div>
            @svg('tabler-user-exclamation', 'w-5 h-5 text-danger-600 animate-bounce')
        </div>

        <div class="text-danger-600 text-sm">
            {{ __('filament-impersonate::banner.impersonating') }} <strong>{{ $display }}</strong>
        </div>

        <x-filament::button
            size="xs"
            color="success"
            icon="tabler-arrow-bar-left"
            icon-position="after"
            tag="a"
            href="{{ route('filament-impersonate.leave') }}"
        >
            {{ __('filament-impersonate::banner.leave') }}
        </x-filament::button>
    </div>
@endIf
