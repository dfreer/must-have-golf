<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <UCard>
                <template #header>
                    <div class="text-center">
                        <UIcon name="i-lucide-mail-check" class="w-12 h-12 text-blue-500 mx-auto mb-4" />
                        <h1 class="text-2xl font-bold">Verify Your Email</h1>
                        <p class="text-gray-600 mt-2">
                            We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.
                        </p>
                    </div>
                </template>

                <div v-if="status === 'verification-link-sent'" class="mb-6">
                    <UAlert
                        icon="i-lucide-check-circle"
                        color="green"
                        variant="soft"
                        title="Verification link sent!"
                        description="A new verification link has been sent to your email address."
                    />
                </div>

                <div class="space-y-4">
                    <UButton
                        @click="resendVerification"
                        block
                        size="lg"
                        :loading="form.processing"
                        icon="i-lucide-refresh-cw"
                        variant="outline"
                    >
                        Resend Verification Email
                    </UButton>

                    <UButton
                        @click="logout"
                        block
                        size="lg"
                        variant="ghost"
                        icon="i-lucide-log-out"
                    >
                        Logout
                    </UButton>
                </div>
            </UCard>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineProps({
    status: String,
})

const form = useForm({})

const resendVerification = () => {
    form.post(route('verification.send'))
}

const logout = () => {
    form.post(route('logout'))
}
</script>
