import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({

    plugins: [
        laravel({
            input: [
                'resources/css/catalog/app.css',
                'resources/js/catalog/app.js',
                'resources/css/product/app.css',
                'resources/js/product/app.js',
                'resources/js/all.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
