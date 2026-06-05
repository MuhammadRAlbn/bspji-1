import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules/alpinejs')) {
                        return 'vendor-alpine';
                    }
                    if (id.includes('node_modules/aos')) {
                        return 'vendor-aos';
                    }
                    if (id.includes('node_modules/leaflet')) {
                        return 'vendor-leaflet';
                    }
                    if (id.includes('node_modules/lucide')) {
                        return 'vendor-lucide';
                    }
                },
            },
        },
    },
});
