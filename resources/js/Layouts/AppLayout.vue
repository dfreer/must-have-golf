<template>
  <div class="min-h-screen bg-gray-50">
    <UHeader class="border-b border-gray-200">
      <template #left>
        <h1 class="text-xl font-bold text-gray-900">
          {{ $page.props.app?.name || 'Laravel' }}
        </h1>
      </template>

      <template #right>
        <UButton
          variant="ghost"
          size="sm"
          icon="i-heroicons-user"
        >
          Profile
        </UButton>
      </template>
    </UHeader>

    <UMain>
      <UContainer class="py-8">
        <slot />
      </UContainer>
    </UMain>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
</script>
