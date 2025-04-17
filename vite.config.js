import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'  // Make sure this is included
            ],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: [
            '@fortawesome/fontawesome-free',
            'bootstrap'
        ]
    },
    build: {
        manifest: true,
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
                entryFileNames: 'assets/[name]-[hash].js'
            }
        }
    }
});
