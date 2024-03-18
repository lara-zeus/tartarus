<div>
    <div x-cloak x-show="$store.isLoading.value"
         class="fixed max-sm:bottom-4 sm:top-4 left-1/2 -translate-x-1/2 z-[6000001]">
        <div class="flex gap-x-2 justify-center bg-white border text-primary-800 border-gray-300 dark:border-gray-800 dark:bg-gray-1000 px-3 py-3 sm:py-2 dark:text-white rounded-lg
        drop-shadow-[0_1px_8px_var(--tw-shadow-color)] dark:shadow-gray-600/30 shadow-gray-200
    ">
            <x-filament::loading-indicator class="h-5 w-5"/>
            <div class="text-sm hidden sm:block">
                {{ __('app.processing') }}
            </div>
        </div>
    </div>
    <div class="text-center text-gray-400 text-sm py-10">
        {{ now()->format('Y') }} &copy; {{ config('app.name') }}
    </div>
    <script>
        document.addEventListener('alpine:init', () => Alpine.store('isLoading', {
            value: false,
            delayTimer: null,
            set(value) {
                clearTimeout(this.delayTimer);
                if (value === false) this.value = false;
                else this.delayTimer = setTimeout(() => this.value = true, 1500);
            }
        }))

        document.addEventListener("livewire:init", () => {
            Livewire.hook('commit.prepare', () => Alpine.store('isLoading').set(true))
            Livewire.hook('commit', ({succeed}) => succeed(() => queueMicrotask(() => Alpine.store('isLoading').set(false))))
        })
    </script>

</div>