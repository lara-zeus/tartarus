<div class="relative">
    <x-filament::dropdown maxHeight="250px" placement="left-start" teleport="true">
        <x-slot name="trigger">
            <div class="text-sm text-gray-700 p-2 flex items-center justify-start gap-2">
                <x-filament::icon
                        icon="heroicon-c-chevron-left"
                        class="mx-1 h-5 w-5 text-gray-400 dark:text-gray-400"
                />
                {{ __('Change Language') }}
            </div>
        </x-slot>

        <x-filament::dropdown.header
                class="font-semibold"
                color="primary"
                icon="tabler-language-katakana"
                href="#"
                tag="a"
        >
            {{ __('Select Language') }}
        </x-filament::dropdown.header>

        <x-filament::dropdown.list>
            @foreach(config('app.locales') as $local => $localInfo)
                <x-filament::dropdown.list.item
                        class="font-semibold"
                        :disabled="app()->getLocale() === $local"
                        {{--:color="(app()->getLocale() === $local) ? 'primary' : null"--}}
                        :icon="app()->getLocale() === 'ar' ? 'heroicon-m-chevron-left' : 'heroicon-m-chevron-right'"
                        :href="url('lang/'.$local)"
                        tag="a"
                >
                    <div class="flex gap-2">
                        <span class="flag-icons flag-icons-{{ $localInfo['flag'] }}"></span>
                        {{ str($localInfo['native'])->title() }}
                    </div>
                </x-filament::dropdown.list.item>
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>
