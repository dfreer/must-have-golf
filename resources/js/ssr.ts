import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createSSRApp, h } from 'vue'
import { renderToString } from 'vue/server-renderer'
import NuxtUI from '@nuxt/ui/vue-plugin'
import type { DefineComponent } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
    serverHead: true,
    layout: () => DefaultLayout,
    resolve: (name) => resolvePageComponent<DefineComponent>(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
    ),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(plugin)
        .use(NuxtUI)
    },
  }),
)
