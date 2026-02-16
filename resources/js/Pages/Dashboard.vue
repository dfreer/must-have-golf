<template>
  <AppLayout>
    <UCard>
      <template #header>
        <div class="flex items-center gap-3">
          <UIcon
            name="i-heroicons-squares-2x2"
            class="text-blue-600 w-6 h-6"
          />
          <h1 class="text-3xl font-bold">Dashboard</h1>
        </div>
      </template>

      <div class="space-y-6">
        <UAlert
          color="green"
          variant="soft"
          title="Welcome!"
          description="You're logged in successfully and viewing your dashboard."
          icon="i-heroicons-check-circle"
        />

        <div>
          <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <UIcon
              name="i-heroicons-chart-bar"
              class="text-blue-500 w-5 h-5"
            />
            Quick Stats:
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <UCard>
              <div class="text-center">
                <UIcon
                  name="i-heroicons-users"
                  class="text-blue-500 w-8 h-8 mx-auto mb-2"
                />
                <div class="text-2xl font-bold text-gray-900">{{ $page.props.auth.user.name }}</div>
                <div class="text-sm text-gray-500">Current User</div>
              </div>
            </UCard>

            <UCard>
              <div class="text-center">
                <UIcon
                  name="i-heroicons-envelope"
                  class="text-green-500 w-8 h-8 mx-auto mb-2"
                />
                <div class="text-2xl font-bold text-gray-900">{{ $page.props.auth.user.email }}</div>
                <div class="text-sm text-gray-500">Email Address</div>
              </div>
            </UCard>

            <UCard>
              <div class="text-center">
                <UIcon
                  name="i-heroicons-clock"
                  class="text-purple-500 w-8 h-8 mx-auto mb-2"
                />
                <div class="text-2xl font-bold text-gray-900">Active</div>
                <div class="text-sm text-gray-500">Account Status</div>
              </div>
            </UCard>
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <UButton
            size="lg"
            icon="i-heroicons-user"
            @click="$inertia.visit(route('profile.edit'))"
          >
            Edit Profile
          </UButton>

          <UButton
            size="lg"
            variant="outline"
            color="gray"
            icon="i-heroicons-home"
            @click="$inertia.visit('/')"
          >
            Back to Home
          </UButton>
        </div>
      </div>
    </UCard>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

const { props: pageProps } = usePage()
</script>
