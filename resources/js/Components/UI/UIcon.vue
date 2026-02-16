<template>
  <component
    :is="iconComponent"
    :class="iconClasses"
  />
</template>

<script setup>
import { computed } from 'vue'
import * as HeroiconsSolid from '@heroicons/vue/20/solid'
import * as HeroiconsOutline from '@heroicons/vue/24/outline'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: 'md'
  }
})

const iconComponent = computed(() => {
  if (!props.name) return null

  // Handle Heroicons format (i-heroicons-*)
  if (props.name.startsWith('i-heroicons-')) {
    const iconName = props.name.replace('i-heroicons-', '')
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

const iconClasses = computed(() => {
  const sizeClasses = {
    xs: 'w-3 h-3',
    sm: 'w-4 h-4',
    md: 'w-5 h-5',
    lg: 'w-6 h-6',
    xl: 'w-8 h-8'
  }

  return sizeClasses[props.size] || sizeClasses.md
})
</script>
