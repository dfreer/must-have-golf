<template>
  <GuestLayout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div class="text-center">
          <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Forgot your password?
          </h2>
          <p class="mt-2 text-sm text-gray-600">
            No problem. Just let us know your email address and we will email you a password reset link.
          </p>
        </div>

        <UCard>
          <div
            v-if="status"
            class="mb-4"
          >
            <UAlert
              color="green"
              variant="soft"
              title="Email Sent"
              :description="status"
              icon="i-heroicons-check-circle"
            />
          </div>

          <form
            @submit.prevent="submit"
            class="space-y-6"
          >
            <UFormGroup
              label="Email address"
              required
            >
              <UInput
                v-model="form.email"
                type="email"
                placeholder="your@email.com"
                required
                autofocus
                autocomplete="email"
                icon="i-heroicons-envelope"
              />
              <div
                v-if="form.errors.email"
                class="text-red-500 text-sm mt-1"
              >
                {{ form.errors.email }}
              </div>
            </UFormGroup>

            <UButton
              type="submit"
              color="primary"
              variant="solid"
              size="lg"
              block
              :loading="form.processing"
              icon="i-heroicons-paper-airplane"
            >
              Email Password Reset Link
            </UButton>

            <div class="text-center mt-4">
              <Link
                href="/login"
                class="text-sm font-medium text-primary-600 hover:text-primary-500"
              >
              Back to login
              </Link>
            </div>
          </form>
        </UCard>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps({
  status: String,
})

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>
