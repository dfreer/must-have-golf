<script setup lang="ts">
defineProps<{
    title: string
}>()
</script>

<template>
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-4 px-6 py-16 lg:px-8">
        <h1 class="text-4xl font-semibold tracking-tight text-stone-950 dark:text-stone-50">
            {{ title }}
        </h1>
        <p class="max-w-2xl text-lg leading-8 text-stone-600 dark:text-stone-400">
            This page is ready for content.
        </p>
    </section>
</template>
