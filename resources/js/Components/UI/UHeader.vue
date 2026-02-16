<template>
  <div class="bg-white shadow">
    <slot />
  </div>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    default: null
  },
  sticky: {
    type: Boolean,
    default: false
  }
})
</script>
