<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <UCard>
                <template #header>
                    <div class="text-center">
                        <h1 class="text-2xl font-bold">Reset Password</h1>
                        <p class="text-gray-600 mt-2">Create a new password for your account.</p>
                    </div>
                </template>

                <form @submit.prevent="submit" class="space-y-6">
                    <UFormGroup label="Email" name="email" required>
                        <UInput
                            v-model="form.email"
                            type="email"
                            placeholder="Enter your email"
                            icon="i-lucide-mail"
                            :error="form.errors.email"
                        />
                    </UFormGroup>

                    <UFormGroup label="New Password" name="password" required>
                        <UInput
                            v-model="form.password"
                            type="password"
                            placeholder="Enter new password"
                            icon="i-lucide-lock"
                            :error="form.errors.password"
                        />
                    </UFormGroup>

                    <UFormGroup label="Confirm Password" name="password_confirmation" required>
                        <UInput
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="Confirm new password"
                            icon="i-lucide-lock"
                            :error="form.errors.password_confirmation"
                        />
                    </UFormGroup>

                    <UButton
                        type="submit"
                        block
                        size="lg"
                        :loading="form.processing"
                        icon="i-lucide-save"
                    >
                        Reset Password
                    </UButton>
                </form>
            </UCard>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    token: String,
    email: String,
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('password.store'))
}
</script>
