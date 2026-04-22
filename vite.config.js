import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/store/store-setup.js',
                'resources/js/auth/register.js',
                'resources/js/auth/login.js',
                'resources/js/store/create-product.js',
                'resources/js/store/myStore.js',
                'resources/js/globalUtils/notifications.js',
                'resources/js/shop/products-loader.js',
                'resources/js/chat/chat.js',
                'resources/js/admin/categories.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
