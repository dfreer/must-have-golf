<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import auth from '@/routes/auth';

defineOptions({ layout: DefaultLayout });

defineProps<{
  email: string;
}>();
</script>

<template>

  <Head title="Verify sign-in code" />

  <div class="mx-auto flex min-h-[calc(100vh-170px)] w-full max-w-md items-center px-6 py-16">
    <div class="w-full space-y-8">
      <div class="space-y-3">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-400">Check your
          inbox</p>
        <h1 class="text-3xl font-semibold tracking-tight">Enter your sign-in code</h1>
        <p class="text-stone-600 dark:text-stone-400">We sent a six-digit code to <strong
            class="font-medium text-stone-950 dark:text-white"
          >{{ email }}</strong>.</p>
      </div>

      <Form
        v-bind="auth.otp.verify.form()"
        #default="{ errors, processing }"
        class="space-y-5"
      >
        <UFormField
          label="Verification code"
          name="code"
          :error="errors.code"
        >
          <UInput
            id="code"
            name="code"
            inputmode="numeric"
            autocomplete="one-time-code"
            maxlength="6"
            placeholder="000000"
            size="lg"
            class="w-full"
          />
        </UFormField>

        <UButton
          type="submit"
          size="lg"
          block
          :loading="processing"
          label="Verify and sign in"
        />
      </Form>

      <Link
        :href="auth.login.url()"
        class="block text-center text-sm font-medium text-stone-600 hover:text-stone-950 dark:text-stone-400 dark:hover:text-white"
      >
        Use a different email address
      </Link>
    </div>
  </div>
</template>
