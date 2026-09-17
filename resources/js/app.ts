import { createInertiaApp } from '@inertiajs/vue3';
import NuxtUI from '@nuxt/ui/vue-plugin';
import { createApp, h } from 'vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    setup({ App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(NuxtUI);
    },
    progress: {
        color: '#4B5563',
    },
});
