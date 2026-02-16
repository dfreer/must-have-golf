<template>
  <div class="flex items-center">
    <input
      :id="id"
      v-model="localValue"
      type="checkbox"
      :class="checkboxClasses"
      :disabled="disabled"
    />
    <label
      :for="id"
      class="ml-2 block text-sm text-gray-900"
      :class="{ 'opacity-50': disabled }"
    >
      <slot>{{ label }}</slot>
    </label>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  label: {
    type: String,
    default: null
  },
  disabled: {
    type: Boolean,
    default: false
  },
  color: {
    type: String,
    default: 'primary'
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  id: {
    type: String,
    default: () => `checkbox-${Math.random().toString(36).substr(2, 9)}`
  }
})

const emit = defineEmits(['update:modelValue'])

const localValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const checkboxClasses = computed(() => {
  const baseClasses = 'rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed'

  const sizeClasses = {
    sm: 'h-3 w-3',
    md: 'h-4 w-4',
    lg: 'h-5 w-5'
  }

  return [
    baseClasses,
    sizeClasses[props.size]
  ].join(' ')
})
</script>
