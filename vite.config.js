import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Include your SCSS file here
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Optional: Include global SCSS variables or mixins
                // additionalData: '@import "@/resources/sass/_variables.scss";'
            },
        },
        postcss: {
            plugins: [
                tailwindcss(),
            ],
        },
    },
});
