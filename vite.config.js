import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/dashboard-lazy-loading.js',
                'resources/js/chambers-lazy-loading.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',  // Force IPv4
        port: 5173,
    },
});
