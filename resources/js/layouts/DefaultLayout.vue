<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import auth from '@/routes/auth';
import { home } from '@/routes';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-stone-50 text-stone-950 dark:bg-stone-950 dark:text-stone-50">
        <header class="border-b border-stone-200 bg-white/90 dark:border-stone-800 dark:bg-stone-950/90">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-5 lg:px-8">
                <Link :href="home.url()" class="text-lg font-semibold tracking-tight">
                    Must Have Golf
                </Link>
                <Link :href="auth.login.url()" class="text-sm font-medium text-stone-600 hover:text-stone-950 dark:text-stone-400 dark:hover:text-white">
                    Sign in
                </Link>
            </div>
        </header>

        <main class="flex-1">
            <slot />
        </main>

        <footer class="border-t border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-950">
            <div class="mx-auto w-full max-w-6xl px-6 py-6 text-sm text-stone-500 lg:px-8">
                © {{ new Date().getFullYear() }} Must Have Golf
            </div>
        </footer>
    </div>
</template>
