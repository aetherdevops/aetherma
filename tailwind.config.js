import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
            typography: ({ theme }) => ({
                aether: {
                    css: {
                        '--tw-prose-body': theme('colors.aether.accent'),
                        '--tw-prose-headings': theme('colors.aether.ink'),
                        '--tw-prose-lead': theme('colors.aether.accent'),
                        '--tw-prose-links': theme('colors.aether.primary'),
                        '--tw-prose-bold': theme('colors.aether.ink'),
                        '--tw-prose-counters': theme('colors.aether.soft'),
                        '--tw-prose-bullets': theme('colors.aether.soft'),
                        '--tw-prose-hr': theme('colors.aether.line'),
                        '--tw-prose-quotes': theme('colors.aether.ink'),
                        '--tw-prose-quote-borders': theme('colors.aether.soft'),
                        '--tw-prose-captions': theme('colors.aether.accent'),
                    },
                },
            }),
        },
    },

    plugins: [forms, typography],
};
