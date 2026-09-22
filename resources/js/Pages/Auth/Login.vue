<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import auth from '@/routes/auth'

defineProps<{
  providers: Array<{ value: string; label: string }>
}>()
</script>

<template>

  <div class="mx-auto flex min-h-[calc(100vh-170px)] w-full max-w-md items-center px-6 py-16">
    <div class="w-full space-y-8">
      <div class="space-y-3">
        <h1 class="text-3xl font-semibold tracking-tight">Sign in to your account</h1>
      </div>

      <div class="grid gap-3 sm:grid-cols-3">
        <UButton
          v-for="provider in providers"
          :key="provider.value"
          :href="auth.social.redirect.url(provider.value)"
          variant="outline"
          color="neutral"
          size="lg"
          :label="provider.label"
          external
        />
      </div>

      <USeparator label="or" />

      <Form
        v-bind="auth.otp.request.form()"
        #default="{ errors, processing }"
        class="space-y-5"
      >
        <UFormField
          label="Email address"
          name="email"
          :error="errors.email"
        >
          <UInput
            id="email"
            name="email"
            type="email"
            placeholder="you@example.com"
            size="lg"
            class="w-full"
          />
        </UFormField>

        <UButton
          type="submit"
          size="lg"
          block
          :loading="processing"
          label="Email me a sign-in code"
        />
      </Form>
    </div>
  </div>
</template>
