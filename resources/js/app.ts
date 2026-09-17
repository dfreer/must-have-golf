import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import NuxtUI from '@nuxt/ui/vue-plugin';
import { createApp, h } from 'vue';
import type { DefineComponent } from 'vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent<DefineComponent>(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        if (!el) {
            return;
        }

        const vueApp = createApp({ render: () => h(App, props) });

        vueApp.use(plugin).use(NuxtUI).mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
