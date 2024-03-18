<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="register">
        {{ $this->form }}

        <x-filament::button type="submit">{{ __('Save') }}</x-filament::button>
    </x-filament-panels::form>
</x-filament-panels::page.simple>
