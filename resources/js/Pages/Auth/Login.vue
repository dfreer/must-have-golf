<template>
  <AppLayout>
    <div class="max-w-md mx-auto">
      <UCard>
        <template #header>
          <div class="text-center">
            <h1 class="text-2xl font-bold">Sign In</h1>
            <p class="text-gray-600 mt-2">Welcome back! Please sign in to your account.</p>
          </div>
        </template>

        <form
          @submit.prevent="submit"
          class="space-y-6"
        >
          <UFormGroup
            label="Email"
            name="email"
            required
            :error="form.errors.email"
          >
            <UInput
              v-model="form.email"
              type="email"
              placeholder="Enter your email"
              icon="i-heroicons-envelope"
            />
          </UFormGroup>

          <UFormGroup
            label="Password"
            name="password"
            required
            :error="form.errors.password"
          >
            <UInput
              v-model="form.password"
              type="password"
              placeholder="Enter your password"
              icon="i-heroicons-lock-closed"
            />
          </UFormGroup>

          <div class="flex items-center justify-between">
            <UCheckbox
              v-model="form.remember"
              label="Remember me"
            />

            <UButton
              variant="link"
              size="sm"
              @click="$inertia.visit(route('password.request'))"
            >
              Forgot password?
            </UButton>
          </div>

          <UButton
            type="submit"
            block
            size="lg"
            :loading="form.processing"
            icon="i-heroicons-arrow-right-on-rectangle"
          >
            Sign In
          </UButton>
        </form>

        <template #footer>
          <div class="text-center">
            <span class="text-gray-600">Don't have an account?</span>
            <UButton
              variant="link"
              size="sm"
              @click="$inertia.visit(route('register'))"
            >
              Sign up
            </UButton>
          </div>
        </template>
      </UCard>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'))
}
</script>
