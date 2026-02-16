<template>
  <div :class="inputWrapperClasses">
    <div
      v-if="icon || $slots.leading"
      class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
    >
      <component
        v-if="icon"
        :is="iconComponent"
        class="h-5 w-5 text-gray-400"
      />
      <slot name="leading" />
    </div>

    <input
      v-bind="$attrs"
      :value="modelValue"
      :class="inputClasses"
      :placeholder="placeholder"
      @input="$emit('update:modelValue', $event.target.value)"
    />

    <div
      v-if="$slots.trailing"
      class="absolute inset-y-0 right-0 pr-3 flex items-center"
    >
      <slot name="trailing" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import * as HeroiconsSolid from '@heroicons/vue/20/solid'
import * as HeroiconsOutline from '@heroicons/vue/24/outline'

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  color: {
    type: String,
    default: 'white'
  },
  variant: {
    type: String,
    default: 'outline',
    validator: (value) => ['outline', 'none'].includes(value)
  },
  placeholder: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

defineEmits(['update:modelValue'])

const iconComponent = computed(() => {
  if (!props.icon) return null

  // Handle Heroicons format (i-heroicons-*)
  if (props.icon.startsWith('i-heroicons-')) {
    const iconName = props.icon.replace('i-heroicons-', '')
    const pascalCase = iconName.split('-').map(word =>
      word.charAt(0).toUpperCase() + word.slice(1)
    ).join('')

    // Try solid first, then outline
    const solidName = `${pascalCase}Icon`
    const outlineName = `${pascalCase}Icon`

    return HeroiconsSolid[solidName] || HeroiconsOutline[outlineName]
  }

  return null
})

const sizeClasses = computed(() => {
  const sizes = {
    xs: 'px-2.5 py-1.5 text-xs',
    sm: 'px-3 py-2 text-sm',
    md: 'px-3 py-2 text-sm',
    lg: 'px-4 py-2 text-base',
    xl: 'px-4 py-3 text-lg'
  }
  return sizes[props.size]
})

const inputWrapperClasses = computed(() => {
  return 'relative'
})

const inputClasses = computed(() => {
  const baseClasses = 'block w-full rounded-md border-0 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200'

  const variantClasses = {
    outline: 'ring-gray-300 placeholder:text-gray-400 focus:ring-primary-600',
    none: 'ring-0 focus:ring-0'
  }

  const paddingClasses = props.icon ? 'pl-10 pr-3' : 'px-3'

  return [
    baseClasses,
    variantClasses[props.variant],
    sizeClasses.value,
    paddingClasses
  ].join(' ')
})
</script>
