<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import auth from '@/routes/auth';

defineOptions({ layout: DefaultLayout });

defineProps<{
  providers: Array<{ value: string; label: string }>;
}>();
</script>

<template>

  <Head title="Sign in" />

  <div class="mx-auto flex min-h-[calc(100vh-170px)] w-full max-w-md items-center px-6 py-16">
    <div class="w-full space-y-8">
      <div class="space-y-3">
        <h1 class="text-3xl font-semibold tracking-tight">Sign in to your account</h1>
        <p class="text-stone-600 dark:text-stone-400">Use your email or continue with a provider. No password required.
        </p>
      </div>

      <Form
        v-bind="auth.otp.request.form()"
        #default="{ errors, processing }"
        class="space-y-5"
      >
        <div class="space-y-2">
          <label
            for="email"
            class="text-sm font-medium"
          >Email address</label>
          <UInput
            id="email"
            name="email"
            type="email"
            placeholder="you@example.com"
            size="lg"
            class="w-full"
          />
          <p
            v-if="errors.email"
            class="text-sm text-red-600"
          >{{ errors.email }}</p>
        </div>

        <UButton
          type="submit"
          size="lg"
          block
          :loading="processing"
        >
          Email me a sign-in code
        </UButton>
      </Form>

      <div class="flex items-center gap-4 text-xs uppercase tracking-[0.2em] text-stone-400">
        <span class="h-px flex-1 bg-stone-200 dark:bg-stone-800" />
        <span>or</span>
        <span class="h-px flex-1 bg-stone-200 dark:bg-stone-800" />
      </div>

      <div class="grid gap-3 sm:grid-cols-3">
        <UButton
          v-for="provider in providers"
          :key="provider.value"
          :href="auth.social.redirect.url(provider.value)"
          variant="outline"
          color="neutral"
          size="lg"
        >
          {{ provider.label }}
        </UButton>
      </div>
    </div>
  </div>
</template>
