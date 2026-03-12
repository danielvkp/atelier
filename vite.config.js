import {
    defineConfig
} from 'vite'

import laravel from 'laravel-vite-plugin';

import vue from '@vitejs/plugin-vue'

import vuetify from 'vite-plugin-vuetify'

import tailwindcss from '@tailwindcss/vite'

import {
    fileURLToPath
} from 'node:url'

import {
    viteStaticCopy
} from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [{
                src: 'resources/js/wow.min.js',
                dest: 'public/assets/css',
            }, ],
        }),
        tailwindcss(),
        laravel(['./vue/app.js',
            './resources/js/app.js',
            './resources/css/tailwind.css',
            './vue_components/components.js'
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({
            autoImport: true,
        }),

    ],
    server: {
        https: false,
        host: 'localhost',
    },
    resolve: {
        alias: {
            '@services': fileURLToPath(new URL('./vue/services',
                import.meta.url)),
            '@mixins': fileURLToPath(new URL('./vue/mixins',
                import.meta.url)),
        },
    },
    /*build: {
        manifest: true,
        outDir: 'public/build',
    },*/
});