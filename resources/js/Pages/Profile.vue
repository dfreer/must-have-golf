<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3'
import account from '@/routes/account'
import type { User } from '@/types/auth'

const page = usePage<{ currentUser: User; flash?: { success?: string } }>()
const currentUser = page.props.currentUser

const dexterityOptions = [
  { label: 'Left-handed', value: 'left' },
  { label: 'Right-handed', value: 'right' },
]

const experienceOptions = [
  { label: 'Beginner', value: 'beginner' },
  { label: 'Intermediate', value: 'intermediate' },
  { label: 'Advanced', value: 'advanced' },
  { label: 'Professional', value: 'pro' },
]
</script>

<template>
  <section class="mx-auto w-full max-w-3xl px-6 py-12 lg:px-8">
    <div class="mb-8 space-y-3">
      <p class="text-sm font-medium uppercase tracking-[0.2em] text-stone-500">Player profile</p>
      <h1 class="text-4xl font-semibold tracking-tight text-stone-950 dark:text-stone-50">Your golf profile</h1>
      <p class="text-lg leading-8 text-stone-600 dark:text-stone-400">
        Keep your player details up to date so future golf recommendations fit your game.
      </p>
    </div>

    <Form
      v-bind="account.profile.update.form()"
      #default="{ errors, processing, recentlySuccessful }"
      class="space-y-6"
    >
      <UFormField
        label="Name"
        name="name"
        :error="errors.name"
      >
        <UInput
          name="name"
          :default-value="currentUser.name"
          autocomplete="name"
          size="lg"
          class="w-full"
        />
      </UFormField>

      <div class="grid gap-6 sm:grid-cols-2">
        <UFormField
          label="Dexterity"
          name="dexterity"
          :error="errors.dexterity"
        >
          <USelect
            name="dexterity"
            :items="dexterityOptions"
            :default-value="currentUser.dexterity ?? undefined"
            placeholder="Select dexterity"
            size="lg"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Experience"
          name="experience"
          :error="errors.experience"
        >
          <USelect
            name="experience"
            :items="experienceOptions"
            :default-value="currentUser.experience ?? undefined"
            placeholder="Select experience"
            size="lg"
            class="w-full"
          />
        </UFormField>
      </div>

      <UFormField
        label="Handicap index"
        name="handicap"
        hint="Use a decimal such as 12.4. Leave blank if you do not have one yet."
        :error="errors.handicap"
      >
        <UInput
          name="handicap"
          type="number"
          min="-10"
          max="54"
          step="0.1"
          :default-value="currentUser.handicap ?? undefined"
          placeholder="12.4"
          size="lg"
          class="w-full"
        />
      </UFormField>

      <div class="flex items-center justify-end gap-4">
        <p
          v-if="recentlySuccessful"
          class="text-sm text-emerald-700 dark:text-emerald-400"
        >
          Profile saved.
        </p>
        <UButton
          type="submit"
          label="Save profile"
          size="lg"
          :loading="processing"
        />
      </div>
    </Form>
  </section>
</template>
