<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
</script>

<template>
    <Head title="Profile" />

    <DashboardLayout
        title="Profile"
        subtitle="Update your account details and keep your SkillSwap profile current."
    >
        <div class="space-y-6">
            <div class="motion-card flex items-center justify-between border border-slate-200 bg-white p-6">
                <div>
                    <h3 class="text-lg font-black text-slate-950">Community Reputation</h3>
                    <p class="mt-1 text-sm text-slate-600">
                        This score reflects your contributions to the SkillSwap community.
                    </p>
                </div>

                <div class="text-right">
                    <span class="text-3xl font-black text-indigo-600">
                        {{ page.props.auth.user.repotation }}
                    </span>
                    <span class="block text-xs font-semibold uppercase tracking-wide text-slate-400">
                        XP Points
                    </span>
                </div>
            </div>

            <div class="motion-card border border-slate-200 bg-white p-6">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="motion-card border border-slate-200 bg-white p-6">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="motion-card border border-slate-200 bg-white p-6">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </DashboardLayout>
</template>
