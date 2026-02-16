<template>
  <GuestLayout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div class="text-center">
          <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Create your account
          </h2>
          <p class="mt-2 text-sm text-gray-600">
            Join us today
          </p>
        </div>

        <UCard>
          <form
            class="space-y-6"
            @submit.prevent="submit"
          >
            <UFormGroup
              label="Name"
              required
            >
              <UInput
                v-model="form.name"
                type="text"
                placeholder="Your full name"
                required
                autofocus
                autocomplete="name"
                icon="i-heroicons-user"
              />
              <div
                v-if="form.errors.name"
                class="text-red-500 text-sm mt-1"
              >
                {{ form.errors.name }}
              </div>
            </UFormGroup>

            <UFormGroup
              label="Email address"
              required
            >
              <UInput
                v-model="form.email"
                type="email"
                placeholder="your@email.com"
                required
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

            <UFormGroup
              label="Password"
              required
            >
              <UInput
                v-model="form.password"
                type="password"
                placeholder="Password"
                required
                autocomplete="new-password"
                icon="i-heroicons-lock-closed"
              />
              <div
                v-if="form.errors.password"
                class="text-red-500 text-sm mt-1"
              >
                {{ form.errors.password }}
              </div>
            </UFormGroup>

            <UFormGroup
              label="Confirm Password"
              required
            >
              <UInput
                v-model="form.password_confirmation"
                type="password"
                placeholder="Confirm password"
                required
                autocomplete="new-password"
                icon="i-heroicons-lock-closed"
              />
              <div
                v-if="form.errors.password_confirmation"
                class="text-red-500 text-sm mt-1"
              >
                {{ form.errors.password_confirmation }}
              </div>
            </UFormGroup>

            <UButton
              type="submit"
              color="primary"
              variant="solid"
              size="lg"
              block
              :loading="form.processing"
              icon="i-heroicons-user-plus"
            >
              Create Account
            </UButton>

            <div class="text-center mt-4">
              <p class="text-sm text-gray-600">
                Already have an account?
                <Link
                  href="/login"
                  class="font-medium text-primary-600 hover:text-primary-500"
                >
                Sign in
                </Link>
              </p>
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

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'))
}
</script>
