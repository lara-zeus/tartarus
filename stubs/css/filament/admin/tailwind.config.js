import preset from '../../../../vendor/filament/filament/tailwind.config.preset'
const colors = require('tailwindcss/colors')

export default {
    presets: [preset],
    colors: {
        ...colors,
        primary: colors.sky,
        secondary: colors.amber,
        gray: colors.gray,
        danger: colors.red,
        success: colors.green,
        warning: colors.yellow,
        info: colors.blue,
    },
    content: [
        "./resources/views/**/*.blade.php",
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/lara-zeus/chaos/resources/views/**/*.blade.php',
        './vendor/lara-zeus/popover/resources/views/**/*.blade.php',
        './vendor/awcodes/filament-curator/resources/**/*.blade.php',
        './vendor/archilex/filament-filter-sets/**/*.php',
    ],
    plugins: [
        require("tailwindcss/nesting"),
    ],
}
