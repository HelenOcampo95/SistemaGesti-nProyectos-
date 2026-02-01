import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
        input: [
            'resources/js/app.js',
            'resources/js/inicio_sesion/inicio_sesion.js',
            'resources/js/inicio_sesion/registro.js'
        ],
        refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
        '@': path.resolve(__dirname, 'resources/js'),
        // 👇 ESTA LÍNEA corrige tu advertencia
        'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
})