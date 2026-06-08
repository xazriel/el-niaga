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
                sans: ['Helvetica', 'Arial', ...defaultTheme.fontFamily.sans],
                helvetica: ['Helvetica', 'Arial', 'sans-serif'],
            },
            colors: {
                brand: {
                    primary: '#1E1E24',
                    white: '#FFFFFF',
                    black: '#000000',
                    olive: '#9A8C73',
                    light: '#F4F3EF',
                }
            }
        },
    },

    plugins: [forms],
};
