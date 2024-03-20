<x-filament::dropdown maxHeight="250px" placement="bottom-start" teleport="true">
    <x-slot name="trigger">
        <div class="bg-cover bg-center h-9 w-9 bg-primary-50 flex items-center justify-center rounded-full">
            @svg('tabler-language-katakana', 'h-6 w-6 text-secondary-500 hover:text-primary-700 transition-all ease-in-out duration-300')
        </div>
    </x-slot>

    <x-filament::dropdown.header iconSize="sm" color="gray" icon="tabler-language-katakana">
        {{ __('Select Language') }}
    </x-filament::dropdown.header>

    <x-filament::dropdown.list>
        @foreach(config('app.locales') as $local => $localInfo)
            <x-filament::dropdown.list.item
                    class="font-semibold"
                    :color="(app()->getLocale() === $local) ? 'primary' : 'secondary'"
                    :icon="(app()->getLocale() === 'ar') ? 'heroicon-m-chevron-left' : 'heroicon-m-chevron-right'"
                    :href="url('lang/'.$local)"
                    tag="a"
            >
                <div class="flex gap-2">
                    {{ str($localInfo['native'])->title() }}
                </div>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
