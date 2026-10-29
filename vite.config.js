import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/desert-adventures/page.css',
                'resources/js/desert-adventures/page.js',
                'resources/js/site-shell.js',
            ],
            refresh: true,
        }),
    ],
});
