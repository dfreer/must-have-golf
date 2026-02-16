<template>
  <AppLayout>
    <UCard>
      <template #header>
        <div class="flex items-center gap-3">
          <UIcon
            name="i-heroicons-bolt"
            class="text-blue-600 w-6 h-6"
          />
          <h1 class="text-3xl font-bold">Welcome to Inertia.js!</h1>
        </div>
      </template>

      <div class="space-y-6">
        <UAlert
          color="blue"
          variant="soft"
          title="Modern Stack"
          description="This page is rendered using Inertia.js with Vue.js and real NuxtUI components."
          icon="i-heroicons-information-circle"
        />

        <div>
          <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <UIcon
              name="i-heroicons-star"
              class="text-yellow-500 w-5 h-5"
            />
            Features:
          </h2>

          <div class="grid gap-3">
            <UCard>
              <div class="flex items-center gap-3">
                <UIcon
                  name="i-heroicons-server"
                  class="text-blue-500 w-5 h-5"
                />
                <span>Server-side routing</span>
              </div>
            </UCard>

            <UCard>
              <div class="flex items-center gap-3">
                <UIcon
                  name="i-heroicons-computer-desktop"
                  class="text-green-500 w-5 h-5"
                />
                <span>Client-side rendering</span>
              </div>
            </UCard>

            <UCard>
              <div class="flex items-center gap-3">
                <UIcon
                  name="i-heroicons-wifi"
                  class="text-purple-500 w-5 h-5"
                />
                <span>No API required</span>
              </div>
            </UCard>

            <UCard>
              <div class="flex items-center gap-3">
                <UIcon
                  name="i-heroicons-code-bracket"
                  class="text-indigo-500 w-5 h-5"
                />
                <span>Vue.js components with real NuxtUI</span>
              </div>
            </UCard>
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <UButton
            size="lg"
            icon="i-heroicons-book-open"
          >
            Read Documentation
          </UButton>

          <UButton
            size="lg"
            variant="outline"
            color="gray"
            icon="i-heroicons-link"
          >
            View on GitHub
          </UButton>
        </div>
      </div>
    </UCard>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>
