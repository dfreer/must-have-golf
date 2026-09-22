<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, ref, watch } from 'vue'
import { useToast } from '@nuxt/ui/composables'
import auth from '@/routes/auth'
import { builder, completedBuilds, guides, home, products } from '@/routes'
import account from '@/routes/account'

const page = usePage()
const toast = useToast()
const currentUser = computed(() => page.props.currentUser)
const appearance = ref<'light' | 'dark' | 'system'>('system')

const applyAppearance = (mode: 'light' | 'dark' | 'system'): void => {
  appearance.value = mode
  localStorage.setItem('appearance', mode)
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
  document.documentElement.classList.toggle('dark', mode === 'dark' || (mode === 'system' && prefersDark))
}

onMounted(() => {
  const storedAppearance = localStorage.getItem('appearance')

  if (storedAppearance === 'light' || storedAppearance === 'dark' || storedAppearance === 'system') {
    appearance.value = storedAppearance
  }

  applyAppearance(appearance.value)
})

watch(
  () => page.props.flash?.toast,
  (toastProps) => {
    if (toastProps) {
      toast.add(toastProps)
    }
  },
  { immediate: true },
)

const navigation = [
  { label: 'Builder', href: builder.url() },
  { label: 'Products', href: products.url() },
  { label: 'Guides', href: guides.url() },
  { label: 'Completed Builds', href: completedBuilds.url() },
]

const accountItems = computed(() => [
  [{ label: currentUser.value?.name ?? 'Account', type: 'label' as const }],
  [
    { label: 'Profile', icon: 'i-lucide-user', to: account.profile.show.url() },
    { label: 'Account', icon: 'i-lucide-settings-2', to: account.settings.url() },
  ],
  [{
    label: 'Sign out',
    icon: 'i-lucide-log-out',
    onSelect: () => router.post(auth.logout.url()),
  }],
])
</script>

<template>
  <UApp :toaster="{ duration: 5000 }">
    <div class="flex min-h-screen flex-col bg-stone-50 text-stone-950 dark:bg-stone-950 dark:text-stone-50">
      <header class="border-b border-stone-200 bg-white/90 dark:border-stone-800 dark:bg-stone-950/90">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-8 px-6 py-5 lg:px-8">
          <ULink
            :href="home.url()"
            class="text-lg font-semibold tracking-tight"
          >
            Must Have Golf
          </ULink>
          <div class="flex items-center gap-6">
            <nav
              class="hidden items-center gapx-2 md:flex"
              aria-label="Primary navigation"
            >
              <UButton
                v-for="item in navigation"
                :key="item.label"
                :href="item.href"
                :label="item.label"
                variant="ghost"
              />
            </nav>

            <UDropdownMenu
              v-if="currentUser"
              :items="accountItems"
              :content="{ align: 'end' }"
              :ui="{ content: 'w-64' }"
            >
              <button
                type="button"
                class="flex items-center gap-2 rounded-full outline-offset-4 focus-visible:outline-2 focus-visible:outline-stone-500"
                :aria-label="`Open ${currentUser.name} account menu`"
              >
                <UAvatar
                  v-if="currentUser.avatar"
                  :src="currentUser.avatar"
                  :alt="currentUser.name"
                  size="sm"
                />
                <UAvatar
                  v-else
                  :alt="currentUser.name"
                  size="sm"
                />
                <span class="hidden text-sm font-medium text-stone-600 sm:inline dark:text-stone-400">
                  {{ currentUser.name }}
                </span>
                <UIcon
                  name="i-lucide-chevron-down"
                  class="size-4 text-stone-500"
                />
              </button>

              <template #content-bottom>
                <div class="border-t border-stone-200 px-2 py-2 dark:border-stone-800">
                  <p class="px-2 pb-2 text-xs font-medium text-stone-500">Appearance</p>
                  <div class="grid grid-cols-3 gap-1">
                    <UButton
                      icon="i-lucide-sun"
                      color="neutral"
                      variant="ghost"
                      size="sm"
                      :class="{ 'bg-stone-100 dark:bg-stone-800': appearance === 'light' }"
                      aria-label="Use light appearance"
                      @click="applyAppearance('light')"
                    />
                    <UButton
                      icon="i-lucide-moon"
                      color="neutral"
                      variant="ghost"
                      size="sm"
                      :class="{ 'bg-stone-100 dark:bg-stone-800': appearance === 'dark' }"
                      aria-label="Use dark appearance"
                      @click="applyAppearance('dark')"
                    />
                    <UButton
                      icon="i-lucide-monitor"
                      color="neutral"
                      variant="ghost"
                      size="sm"
                      :class="{ 'bg-stone-100 dark:bg-stone-800': appearance === 'system' }"
                      aria-label="Use system appearance"
                      @click="applyAppearance('system')"
                    />
                  </div>
                </div>
              </template>

            </UDropdownMenu>
            <UButton
              v-else
              :href="auth.login.url()"
              :label="'Sign in'"
              variant="solid"
            />
          </div>
        </div>
      </header>

      <main class="flex-1">
        <slot />
      </main>

      <footer class="border-t border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-950">
        <div class="mx-auto w-full max-w-6xl px-6 py-6 text-sm text-stone-500 lg:px-8">
          &copy; {{ new Date().getFullYear() }} Must Have Golf
        </div>
      </footer>
    </div>
  </UApp>
</template>
