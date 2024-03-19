<x-filament-panels::page>
    <form wire:submit="saveSettings">
        {{ $this->form }}

        <div class="text-center my-10">
            <x-filament::button type="submit">
                {{ __('zeus-chaos::core.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
