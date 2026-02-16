<template>
  <div class="space-y-1">
    <label
      v-if="label || required"
      :for="id"
      class="block text-sm font-medium text-gray-700"
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red-500"
      >*</span>
    </label>

    <div class="relative">
      <slot />
    </div>

    <p
      v-if="hint"
      class="text-sm text-gray-500"
    >
      {{ hint }}
    </p>

    <p
      v-if="error"
      class="text-sm text-red-600"
    >
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    default: null
  },
  required: {
    type: Boolean,
    default: false
  },
  hint: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  id: {
    type: String,
    default: () => `form-group-${Math.random().toString(36).substr(2, 9)}`
  }
})
</script>
