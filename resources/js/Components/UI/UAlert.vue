<template>
  <div :class="alertClasses">
    <div class="flex">
      <div
        v-if="icon || iconComponent"
        class="flex-shrink-0"
      >
        <component
          :is="iconComponent"
          class="h-5 w-5"
          :class="iconClasses"
        />
      </div>
      <div class="ml-3 flex-1">
        <h3
          v-if="title"
          class="text-sm font-medium"
          :class="titleClasses"
        >
          {{ title }}
        </h3>
        <div
          class="text-sm"
          :class="descriptionClasses"
        >
          <p v-if="description">{{ description }}</p>
          <slot v-else />
        </div>
      </div>
      <div
        v-if="closable"
        class="ml-auto pl-3"
      >
        <div class="-mx-1.5 -my-1.5">
          <button
            type="button"
            class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
            :class="closeButtonClasses"
            @click="$emit('close')"
          >
            <span class="sr-only">Dismiss</span>
            <component
              :is="XMarkIcon"
              class="h-5 w-5"
            />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'
import * as HeroiconsSolid from '@heroicons/vue/20/solid'
import * as HeroiconsOutline from '@heroicons/vue/24/outline'

const props = defineProps({
  color: {
    type: String,
    default: 'blue',
    validator: (value) => ['blue', 'green', 'yellow', 'red', 'gray'].includes(value)
  },
  variant: {
    type: String,
    default: 'soft',
    validator: (value) => ['solid', 'soft', 'outline'].includes(value)
  },
  title: {
    type: String,
    default: null
  },
  description: {
    type: String,
    default: null
  },
  icon: {
    type: String,
    default: null
  },
  closable: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

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

const alertClasses = computed(() => {
  const baseClasses = 'rounded-md p-4'

  const variants = {
    solid: {
      blue: 'bg-blue-600 text-white',
      green: 'bg-green-600 text-white',
      yellow: 'bg-yellow-600 text-white',
      red: 'bg-red-600 text-white',
      gray: 'bg-gray-600 text-white'
    },
    soft: {
      blue: 'bg-blue-50 text-blue-800',
      green: 'bg-green-50 text-green-800',
      yellow: 'bg-yellow-50 text-yellow-800',
      red: 'bg-red-50 text-red-800',
      gray: 'bg-gray-50 text-gray-800'
    },
    outline: {
      blue: 'border border-blue-200 bg-white text-blue-800',
      green: 'border border-green-200 bg-white text-green-800',
      yellow: 'border border-yellow-200 bg-white text-yellow-800',
      red: 'border border-red-200 bg-white text-red-800',
      gray: 'border border-gray-200 bg-white text-gray-800'
    }
  }

  return [
    baseClasses,
    variants[props.variant][props.color]
  ].join(' ')
})

const iconClasses = computed(() => {
  const variants = {
    solid: {
      blue: 'text-blue-200',
      green: 'text-green-200',
      yellow: 'text-yellow-200',
      red: 'text-red-200',
      gray: 'text-gray-200'
    },
    soft: {
      blue: 'text-blue-400',
      green: 'text-green-400',
      yellow: 'text-yellow-400',
      red: 'text-red-400',
      gray: 'text-gray-400'
    },
    outline: {
      blue: 'text-blue-400',
      green: 'text-green-400',
      yellow: 'text-yellow-400',
      red: 'text-red-400',
      gray: 'text-gray-400'
    }
  }

  return variants[props.variant][props.color]
})

const titleClasses = computed(() => {
  return props.variant === 'solid' ? 'text-white' : `text-${props.color}-800`
})

const descriptionClasses = computed(() => {
  return props.variant === 'solid' ? 'text-white' : `text-${props.color}-700`
})

const closeButtonClasses = computed(() => {
  const variants = {
    solid: {
      blue: 'text-blue-200 hover:bg-blue-700 hover:text-white focus:ring-blue-500',
      green: 'text-green-200 hover:bg-green-700 hover:text-white focus:ring-green-500',
      yellow: 'text-yellow-200 hover:bg-yellow-700 hover:text-white focus:ring-yellow-500',
      red: 'text-red-200 hover:bg-red-700 hover:text-white focus:ring-red-500',
      gray: 'text-gray-200 hover:bg-gray-700 hover:text-white focus:ring-gray-500'
    },
    soft: {
      blue: 'text-blue-500 hover:bg-blue-100 focus:ring-blue-600 focus:ring-offset-blue-50',
      green: 'text-green-500 hover:bg-green-100 focus:ring-green-600 focus:ring-offset-green-50',
      yellow: 'text-yellow-500 hover:bg-yellow-100 focus:ring-yellow-600 focus:ring-offset-yellow-50',
      red: 'text-red-500 hover:bg-red-100 focus:ring-red-600 focus:ring-offset-red-50',
      gray: 'text-gray-500 hover:bg-gray-100 focus:ring-gray-600 focus:ring-offset-gray-50'
    },
    outline: {
      blue: 'text-blue-500 hover:bg-blue-100 focus:ring-blue-600',
      green: 'text-green-500 hover:bg-green-100 focus:ring-green-600',
      yellow: 'text-yellow-500 hover:bg-yellow-100 focus:ring-yellow-600',
      red: 'text-red-500 hover:bg-red-100 focus:ring-red-600',
      gray: 'text-gray-500 hover:bg-gray-100 focus:ring-gray-600'
    }
  }

  return variants[props.variant][props.color]
})
</script>
