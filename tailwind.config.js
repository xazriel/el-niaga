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
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                helvetica: ['Plus Jakarta Sans', 'sans-serif'],
            },
            colors: {
                brand: {
                    primary: '#10B981',
                    white: '#FFFFFF',
                    black: '#000000',
                    olive: '#8E8E9F',
                    light: '#F4F3EF',
                }
            }
        },
    },

    plugins: [forms],
};
