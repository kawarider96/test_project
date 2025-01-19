import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/dialog.js', 
                'resources/js/fetchProjects.js',
                'resources/js/fetchTimes.js',
            ],
            refresh: true,
        }),
    ],
});
