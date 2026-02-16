<template>
  <AppLayout>
    <UCard>
      <template #header>
        <div class="flex items-center gap-3">
          <UIcon
            name="i-heroicons-user"
            class="text-blue-600 w-6 h-6"
          />
          <h1 class="text-3xl font-bold">Profile Settings</h1>
        </div>
      </template>

      <div class="space-y-8">
        <!-- Profile Information Section -->
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <UIcon
              name="i-heroicons-identification"
              class="text-blue-500 w-5 h-5"
            />
            Profile Information
          </h3>

          <UCard>
            <form
              @submit.prevent="updateProfile"
              class="space-y-6"
            >
              <UFormGroup
                label="Name"
                required
              >
                <UInput
                  v-model="profileForm.name"
                  type="text"
                  required
                  autocomplete="name"
                  icon="i-heroicons-user"
                />
                <div
                  v-if="profileForm.errors.name"
                  class="text-red-500 text-sm mt-1"
                >
                  {{ profileForm.errors.name }}
                </div>
              </UFormGroup>

              <UFormGroup
                label="Email"
                required
              >
                <UInput
                  v-model="profileForm.email"
                  type="email"
                  required
                  autocomplete="username"
                  icon="i-heroicons-envelope"
                />
                <div
                  v-if="profileForm.errors.email"
                  class="text-red-500 text-sm mt-1"
                >
                  {{ profileForm.errors.email }}
                </div>
              </UFormGroup>

              <div class="flex items-center gap-3">
                <UButton
                  type="submit"
                  color="primary"
                  :loading="profileForm.processing"
                  icon="i-heroicons-check"
                >
                  Save Changes
                </UButton>

                <div
                  v-if="profileForm.recentlySuccessful"
                  class="text-green-600 text-sm"
                >
                  Profile updated successfully!
                </div>
              </div>
            </form>
          </UCard>
        </div>

        <!-- Update Password Section -->
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <UIcon
              name="i-heroicons-lock-closed"
              class="text-yellow-500 w-5 h-5"
            />
            Update Password
          </h3>

          <UCard>
            <form
              @submit.prevent="updatePassword"
              class="space-y-6"
            >
              <UFormGroup
                label="Current Password"
                required
              >
                <UInput
                  v-model="passwordForm.current_password"
                  type="password"
                  required
                  autocomplete="current-password"
                  icon="i-heroicons-lock-closed"
                />
                <div
                  v-if="passwordForm.errors.current_password"
                  class="text-red-500 text-sm mt-1"
                >
                  {{ passwordForm.errors.current_password }}
                </div>
              </UFormGroup>

              <UFormGroup
                label="New Password"
                required
              >
                <UInput
                  v-model="passwordForm.password"
                  type="password"
                  required
                  autocomplete="new-password"
                  icon="i-heroicons-lock-closed"
                />
                <div
                  v-if="passwordForm.errors.password"
                  class="text-red-500 text-sm mt-1"
                >
                  {{ passwordForm.errors.password }}
                </div>
              </UFormGroup>

              <UFormGroup
                label="Confirm Password"
                required
              >
                <UInput
                  v-model="passwordForm.password_confirmation"
                  type="password"
                  required
                  autocomplete="new-password"
                  icon="i-heroicons-lock-closed"
                />
                <div
                  v-if="passwordForm.errors.password_confirmation"
                  class="text-red-500 text-sm mt-1"
                >
                  {{ passwordForm.errors.password_confirmation }}
                </div>
              </UFormGroup>

              <div class="flex items-center gap-3">
                <UButton
                  type="submit"
                  color="yellow"
                  :loading="passwordForm.processing"
                  icon="i-heroicons-key"
                >
                  Update Password
                </UButton>

                <div
                  v-if="passwordForm.recentlySuccessful"
                  class="text-green-600 text-sm"
                >
                  Password updated successfully!
                </div>
              </div>
            </form>
          </UCard>
        </div>

        <!-- Delete Account Section -->
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <UIcon
              name="i-heroicons-trash"
              class="text-red-500 w-5 h-5"
            />
            Delete Account
          </h3>

          <UCard>
            <UAlert
              color="red"
              variant="soft"
              title="Permanent Action"
              description="Once your account is deleted, all of its resources and data will be permanently deleted."
              icon="i-heroicons-exclamation-triangle"
            />

            <div class="mt-6">
              <UButton
                color="red"
                variant="outline"
                icon="i-heroicons-trash"
                @click="confirmUserDeletion"
              >
                Delete Account
              </UButton>
            </div>
          </UCard>
        </div>

        <!-- Navigation -->
        <div class="pt-6 border-t border-gray-200">
          <UButton
            variant="outline"
            color="gray"
            icon="i-heroicons-arrow-left"
            @click="$inertia.visit(route('dashboard'))"
          >
            Back to Dashboard
          </UButton>
        </div>
      </div>
    </UCard>
  </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  user: Object,
  status: String
})

// Profile form
const profileForm = useForm({
  name: props.user.name,
  email: props.user.email,
})

// Password form
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

// Delete account form
const deleteForm = useForm({
  password: '',
})

const updateProfile = () => {
  profileForm.patch(route('profile.update'), {
    preserveScroll: true,
  })
}

const updatePassword = () => {
  passwordForm.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => passwordForm.reset(),
    onError: () => passwordForm.reset('password', 'password_confirmation'),
  })
}

const confirmUserDeletion = () => {
  const password = prompt('Please enter your password to confirm account deletion:')
  if (password) {
    deleteForm.password = password
    deleteForm.delete(route('profile.destroy'), {
      preserveScroll: true,
    })
  }
}
</script>
