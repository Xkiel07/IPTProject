import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // Base path for serving assets, adjust if necessary


    plugins: [
        laravel({
            input: [
                'resources/css/app.css',  // Make sure this path matches the actual file location
                'resources/js/app.js'     // Same here
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
        manifest: true,  // Generates the manifest file for asset versioning

        // Rollup options to control output file names
        rollupOptions: {
            output: {
                // Define asset file names to be hashed for cache-busting
                assetFileNames: 'assets/[name]-[hash][extname]',
                entryFileNames: 'assets/[name]-[hash].js',
            }
        }
    }
});
