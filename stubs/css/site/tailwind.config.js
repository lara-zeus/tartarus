import preset from '../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        "./resources/views/**/*.blade.php",
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/lara-zeus/chaos/resources/views/**/*.blade.php',
        './vendor/lara-zeus/popover/resources/views/**/*.blade.php',
    ],
    plugins: [
        require("tailwindcss/nesting"),
    ],
}
