<template>
  <div :class="containerClasses">
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  size: {
    type: String,
    default: 'max',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl', 'max'].includes(value)
  },
  padding: {
    type: Boolean,
    default: true
  }
})

const containerClasses = computed(() => {
  const sizeClasses = {
    xs: 'max-w-xs',
    sm: 'max-w-sm',
    md: 'max-w-md',
    lg: 'max-w-lg',
    xl: 'max-w-xl',
    '2xl': 'max-w-2xl',
    '3xl': 'max-w-3xl',
    '4xl': 'max-w-4xl',
    '5xl': 'max-w-5xl',
    '6xl': 'max-w-6xl',
    '7xl': 'max-w-7xl',
    max: 'max-w-7xl'
  }

  const classes = [
    'mx-auto',
    sizeClasses[props.size]
  ]

  if (props.padding) {
    classes.push('px-4 sm:px-6 lg:px-8')
  }

  return classes.join(' ')
})
</script>
