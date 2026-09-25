import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                aether: {
                    primary: '#124559',
                    accent: '#516d78',
                    soft: '#598392',
                    cream: '#eff6e0',
                    mist: '#fafbf8',
                    line: '#ced6ea',
                    ink: '#22253d',
                    dusk: '#3d436d',
                },
            },
            fontFamily: {
                display: ['"Kumbh Sans"', ...defaultTheme.fontFamily.sans],
                sans: ['Mulish', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
