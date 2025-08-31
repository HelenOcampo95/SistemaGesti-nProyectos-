import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
           template: {
               transformAssetUrls: {
                   base: null,
                   includeAbsolute: false
               }
           }
        }),
        laravel({
            input: [
                'resources/css/app.css', 'resources/js/app.js',
                'resources/js/proyecto/registrar_proyecto.js',
                'resources/js/categorias/registrar_categoria.js'

            ],
            refresh: true,
        }),
    ],
    define: {
        __VUE_OPTIONS_API__: true, 
        __VUE_PROD_DEVTOOLS__: false, 
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false 
    },
});
