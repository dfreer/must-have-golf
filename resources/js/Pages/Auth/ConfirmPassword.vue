<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <UCard>
                <template #header>
                    <div class="text-center">
                        <UIcon name="i-lucide-shield-check" class="w-12 h-12 text-amber-500 mx-auto mb-4" />
                        <h1 class="text-2xl font-bold">Confirm Password</h1>
                        <p class="text-gray-600 mt-2">
                            This is a secure area of the application. Please confirm your password before continuing.
                        </p>
                    </div>
                </template>

                <form @submit.prevent="submit" class="space-y-6">
                    <UFormGroup label="Password" name="password" required>
                        <UInput
                            v-model="form.password"
                            type="password"
                            placeholder="Enter your password"
                            icon="i-lucide-lock"
                            :error="form.errors.password"
                            autofocus
                        />
                    </UFormGroup>

                    <UButton
                        type="submit"
                        block
                        size="lg"
                        :loading="form.processing"
                        icon="i-lucide-check"
                    >
                        Confirm Password
                    </UButton>
                </form>
            </UCard>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    password: '',
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset('password'),
    })
}
</script>
