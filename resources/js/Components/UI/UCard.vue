<template>
  <div :class="cardClasses">
    <div
      v-if="$slots.header"
      class="px-4 py-5 sm:px-6"
    >
      <slot name="header" />
    </div>

    <div
      v-if="$slots.default"
      :class="bodyClasses"
    >
      <slot />
    </div>

    <div
      v-if="$slots.footer"
      class="px-4 py-4 sm:px-6"
    >
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  color: {
    type: String,
    default: 'white'
  },
  shadow: {
    type: String,
    default: 'sm',
    validator: (value) => ['none', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  rounded: {
    type: String,
    default: 'lg'
  },
  padding: {
    type: Boolean,
    default: true
  }
})

const cardClasses = computed(() => {
  const baseClasses = 'bg-white overflow-hidden'

  const shadowClasses = {
    none: '',
    sm: 'shadow-sm',
    md: 'shadow-md',
    lg: 'shadow-lg',
    xl: 'shadow-xl'
  }

  const roundedClasses = {
    none: '',
    sm: 'rounded-sm',
    md: 'rounded-md',
    lg: 'rounded-lg',
    xl: 'rounded-xl'
  }

  return [
    baseClasses,
    shadowClasses[props.shadow],
    roundedClasses[props.rounded]
  ].join(' ')
})

const bodyClasses = computed(() => {
  return props.padding ? 'px-4 py-5 sm:p-6' : ''
})
</script>
