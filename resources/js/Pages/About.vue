<script setup lang="ts">
import SitemapPage from '@/components/SitemapPage.vue'
defineProps<{ title: string }>()
</script>

<template>
  <SitemapPage :title="title" />
</template>
