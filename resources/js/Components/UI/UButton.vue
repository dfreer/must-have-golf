<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="$emit('click', $event)"
  >
    <component
      v-if="loading"
      :is="LoaderIcon"
      class="animate-spin -ml-1 mr-2 h-4 w-4"
    />
    <component
      v-else-if="icon && !iconTrailing"
      :is="iconComponent"
      class="-ml-1 mr-2 h-4 w-4"
    />
    <span v-if="$slots.default || label">
      <slot>{{ label }}</slot>
    </span>
    <component
      v-if="icon && iconTrailing"
      :is="iconComponent"
      class="ml-2 -mr-1 h-4 w-4"
    />
  </button>
</template>

<script setup>
import { computed } from 'vue'
import { ArrowPathIcon } from '@heroicons/vue/20/solid'
import * as HeroiconsSolid from '@heroicons/vue/20/solid'
import * as HeroiconsOutline from '@heroicons/vue/24/outline'

const props = defineProps({
  type: {
    type: String,
    default: 'button'
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  color: {
    type: String,
    default: 'primary'
  },
  variant: {
    type: String,
    default: 'solid',
    validator: (value) => ['solid', 'outline', 'soft', 'ghost', 'link'].includes(value)
  },
  disabled: {
    type: Boolean,
    default: false
  },
  loading: {
    type: Boolean,
    default: false
  },
  block: {
    type: Boolean,
    default: false
  },
  icon: {
    type: String,
    default: null
  },
  iconTrailing: {
    type: Boolean,
    default: false
  },
  label: {
    type: String,
    default: null
  }
})

defineEmits(['click'])

const LoaderIcon = ArrowPathIcon

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
    md: 'px-4 py-2 text-sm',
    lg: 'px-4 py-2 text-base',
    xl: 'px-6 py-3 text-base'
  }
  return sizes[props.size]
})

const colorClasses = computed(() => {
  const variants = {
    solid: {
      primary: 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-500 text-white',
      gray: 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
      red: 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
      green: 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white'
    },
    outline: {
      primary: 'border-primary-300 text-primary-700 hover:bg-primary-50 focus:ring-primary-500',
      gray: 'border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
      red: 'border-red-300 text-red-700 hover:bg-red-50 focus:ring-red-500',
      green: 'border-green-300 text-green-700 hover:bg-green-50 focus:ring-green-500'
    },
    soft: {
      primary: 'bg-primary-100 text-primary-900 hover:bg-primary-200',
      gray: 'bg-gray-100 text-gray-900 hover:bg-gray-200',
      red: 'bg-red-100 text-red-900 hover:bg-red-200',
      green: 'bg-green-100 text-green-900 hover:bg-green-200'
    },
    ghost: {
      primary: 'text-primary-600 hover:text-primary-900 hover:bg-primary-50',
      gray: 'text-gray-600 hover:text-gray-900 hover:bg-gray-50',
      red: 'text-red-600 hover:text-red-900 hover:bg-red-50',
      green: 'text-green-600 hover:text-green-900 hover:bg-green-50'
    },
    link: {
      primary: 'text-primary-600 hover:text-primary-900 underline-offset-4 hover:underline',
      gray: 'text-gray-600 hover:text-gray-900 underline-offset-4 hover:underline',
      red: 'text-red-600 hover:text-red-900 underline-offset-4 hover:underline',
      green: 'text-green-600 hover:text-green-900 underline-offset-4 hover:underline'
    }
  }

  return variants[props.variant]?.[props.color] || variants.solid.primary
})

const buttonClasses = computed(() => {
  const baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200'

  const classes = [
    baseClasses,
    sizeClasses.value,
    colorClasses.value
  ]

  if (props.block) {
    classes.push('w-full')
  }

  if (props.variant === 'outline') {
    classes.push('border')
  }

  return classes.join(' ')
})
</script>
