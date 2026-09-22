import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import ui from '@nuxt/ui/vite'

const nuxtUiInertiaStub = fileURLToPath(new URL(
    './node_modules/@nuxt/ui/dist/runtime/vue/stubs/inertia.js',
    import.meta.url,
));

export default defineConfig({
    resolve: {
        alias: {
            '#imports': nuxtUiInertiaStub,
        },
    },
    ssr: {
        noExternal: ['@nuxt/ui'],
    },
    plugins: [
        {
            name: 'nuxt-ui-inertia-imports',
            enforce: 'pre',
            resolveId(id) {
                return id === '#imports' ? nuxtUiInertiaStub : undefined;
            },
        },
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
            fonts: [],
        }),
        inertia(),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
        ui({
            router: 'inertia',
            ui: {
                colors: {
                    neutral: 'neutral',
                },
                avatar: {
                    slots: {
                        root: 'border-2',
                    }
                },
                formField: {
                    slots: { root: 'w-full mb-6', label: 'block font-medium text-base', },
                },
                input: {
                    slots: { root: 'w-full', base: 'w-full' },
                    defaultVariants: { size: 'lg' },
                },
                textarea: {
                    slots: { root: 'w-full' },
                },
                select: {
                    slots: { base: 'w-full' },
                },
                button: {
                    slots: { base: 'cursor-pointer' },
                    defaultVariants: { variant: 'outline', color: 'neutral' },
                },
                switch: { slots: { base: 'cursor-pointer' } },
                badge: {
                    default: {},
                },
                card: {
                    slots: {
                        root: 'w-full mb-8 bg-transparent',
                        header: 'flex w-full justify-between items-center text-default font-bold px-6 py-4 border-b border-default ring-0 empty:hidden',
                        body: 'bg-default empty:hidden',
                        footer: 'px-6 py-4 ring-0 empty:hidden',
                    },
                },
                alert: {
                    slots: { root: 'mb-8', }
                },
                table: {
                    slots: { td: 'py-2 px-4', },
                },
                page: {},
            }
        })
    ],
});
