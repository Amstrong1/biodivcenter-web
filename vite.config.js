import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Écoute sur toutes les interfaces réseau
        port: 5173,      // Assurez-vous que ce port est ouvert
        hmr: {
            host: '192.168.63.9', // Utilisez votre adresse IP locale ici
        }
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
