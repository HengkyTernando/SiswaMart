import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Status badge classes used dynamically
        'bg-green-100', 'text-green-800',
        'bg-red-100',   'text-red-800',
        'bg-yellow-100','text-yellow-800',
        'bg-blue-100',  'text-blue-700',
        'bg-blue-50',   'text-blue-600',
        // Category dynamic colors
        'bg-[#FFB084]', 'bg-[#A3D9C9]', 'bg-[#FFD84D]', 'bg-[#D4C4FB]',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // New Brand Colors
                cream: '#FFF8E8',
                offwhite: '#FFFCF5',
                darkbrown: '#241A14',
                brandorange: '#FF7A00',
                brandyellow: '#FFD84D',
                brandgreen: '#5B8C51',
                // Keep brand blue for secondary/admin compatibility if needed
                brand: {
                    50:      '#EFF6FF',
                    100:     '#DBEAFE',
                    200:     '#BFDBFE',
                    300:     '#93C5FD',
                    400:     '#60A5FA',
                    DEFAULT: '#2563EB',
                    600:     '#2563EB',
                    700:     '#1D4ED8',
                    800:     '#1E40AF',
                    900:     '#1E3A8A',
                    950:     '#172554',
                    light:   '#EFF6FF',
                    dark:    '#1D4ED8',
                },
            },
            boxShadow: {
                'solid': '4px 4px 0px 0px rgba(36, 26, 20, 1)',
                'solid-sm': '2px 2px 0px 0px rgba(36, 26, 20, 1)',
                'solid-lg': '6px 6px 0px 0px rgba(36, 26, 20, 1)',
            }
        },
    },

    plugins: [forms],
};
