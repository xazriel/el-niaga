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
                    primary: '#2F3526',
                    white: '#FFFFFF',
                    black: '#000000',
                    olive: '#6B705C',
                    light: '#E9E9E9',
                }
            }
        },
    },

    plugins: [forms],
};
