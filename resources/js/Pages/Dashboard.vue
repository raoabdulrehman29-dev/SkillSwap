<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    teaching: {
        type: Array,
        default: () => [],
    },
    learning: {
        type: Array,
        default: () => [],
    },
});

const allBookings = computed(() => [...props.teaching, ...props.learning]);
const pendingTeaching = computed(() => props.teaching.filter((booking) => booking.status === 'pending'));
const activeBookings = computed(() => allBookings.value.filter((booking) => ['confirmed', 'completed'].includes(booking.status)));
const pendingLearning = computed(() => props.learning.filter((booking) => booking.status === 'pending'));

const statusClasses = {
    pending: 'bg-amber-50 text-amber-700',
    confirmed: 'bg-indigo-50 text-indigo-700',
    completed: 'bg-emerald-50 text-emerald-700',
    cancelled: 'bg-rose-50 text-rose-700',
};

const progressFor = (booking) => {
    if (!booking.milestones?.length) return 0;

    const completed = booking.milestones.filter((milestone) => milestone.is_completed).length;
    return Math.round((completed / booking.milestones.length) * 100);
};

const formatDate = (value) => {
    if (!value) return 'Not scheduled';

    return new Intl.DateTimeFormat('en', {
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
    }).format(new Date(value));
};

const updateBookingStatus = (booking, status) => {
    router.patch(route('bookings.updateStatus', booking.id), { status }, {
        preserveScroll: true,
    });
};

const toggleMilestone = (milestone) => {
    router.patch(route('milestones.toggle', milestone.id), {}, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout
        title="Dashboard"
        subtitle="Manage booking requests, swap progress, and milestones from one place."
    >
        <template #actions>
            <Link
                :href="route('marketplace')"
                class="hidden rounded-md bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 sm:inline-flex"
            >
                Find Swaps
            </Link>
        </template>

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <article class="motion-card border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Teaching</p>
                    <h2 class="mt-3 text-4xl font-black text-slate-950">{{ teaching.length }}</h2>
                </article>
                <article class="motion-card border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Learning</p>
                    <h2 class="mt-3 text-4xl font-black text-slate-950">{{ learning.length }}</h2>
                </article>
                <article class="motion-card border border-slate-200 bg-white p-5">
                    <p class="text-sm font-semibold text-slate-500">Pending review</p>
                    <h2 class="mt-3 text-4xl font-black text-slate-950">{{ pendingTeaching.length }}</h2>
                </article>
                <article class="motion-card border border-indigo-200 bg-indigo-600 p-5 text-white shadow-sm shadow-indigo-200">
                    <p class="text-sm font-semibold text-indigo-100">Active progress</p>
                    <h2 class="mt-3 text-4xl font-black">{{ activeBookings.length }}</h2>
                </article>
            </div>

            <section class="motion-card border border-slate-200 bg-white">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-black text-slate-950">Requests waiting for you</h2>
                    <p class="mt-1 text-sm text-slate-500">Accept or cancel requests from students who want to work with you.</p>
                </div>

                <div v-if="pendingTeaching.length" class="divide-y divide-slate-100">
                    <div v-for="booking in pendingTeaching" :key="booking.id" class="grid gap-4 p-5 lg:grid-cols-[1fr_auto] lg:items-center">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-black text-slate-950">{{ booking.skill?.title ?? 'Skill swap' }}</h3>
                                <span class="rounded-md px-2 py-1 text-xs font-bold capitalize" :class="statusClasses[booking.status]">
                                    {{ booking.status }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ booking.student?.name ?? 'Student' }} wants a session from
                                {{ formatDate(booking.start_time) }} to {{ formatDate(booking.end_time) }}.
                            </p>
                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                {{ booking.milestones?.length ?? 0 }} milestones proposed
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button type="button" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-indigo-700" @click="updateBookingStatus(booking, 'confirmed')">
                                Accept
                            </button>
                            <button type="button" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600" @click="updateBookingStatus(booking, 'cancelled')">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="p-8 text-center">
                    <p class="font-bold text-slate-800">No pending teaching requests.</p>
                    <p class="mt-1 text-sm text-slate-500">New requests will show up here.</p>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="space-y-6 xl:col-span-2">
                    <article
                        v-for="booking in activeBookings"
                        :key="booking.id"
                        class="motion-card border border-slate-200 bg-white"
                    >
                        <div class="border-b border-slate-100 p-5">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-black text-slate-950">{{ booking.skill?.title ?? 'Skill swap' }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ formatDate(booking.start_time) }} to {{ formatDate(booking.end_time) }}
                                    </p>
                                </div>
                                <span class="rounded-md px-2 py-1 text-xs font-bold capitalize" :class="statusClasses[booking.status]">
                                    {{ booking.status }}
                                </span>
                            </div>

                            <div class="mt-5">
                                <div class="flex items-center justify-between text-sm font-bold text-slate-600">
                                    <span>Milestone progress</span>
                                    <span>{{ progressFor(booking) }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-indigo-600 transition-all duration-500" :style="{ width: `${progressFor(booking)}%` }"></div>
                                </div>
                            </div>
                        </div>

                        <div class="divide-y divide-slate-100">
                            <label
                                v-for="milestone in booking.milestones"
                                :key="milestone.id"
                                class="flex cursor-pointer items-start gap-3 p-5 transition hover:bg-slate-50"
                            >
                                <input
                                    type="checkbox"
                                    class="mt-1 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    :checked="milestone.is_completed"
                                    @change="toggleMilestone(milestone)"
                                >
                                <span class="min-w-0">
                                    <span class="block font-bold text-slate-900" :class="{ 'line-through opacity-60': milestone.is_completed }">
                                        {{ milestone.title }}
                                    </span>
                                    <span v-if="milestone.description" class="mt-1 block text-sm text-slate-500">
                                        {{ milestone.description }}
                                    </span>
                                    <span v-if="milestone.completed_at" class="mt-1 block text-xs font-semibold text-emerald-600">
                                        Completed {{ formatDate(milestone.completed_at) }}
                                    </span>
                                </span>
                            </label>
                        </div>
                    </article>

                    <div v-if="!activeBookings.length" class="motion-card border border-slate-200 bg-white p-8 text-center">
                        <p class="text-lg font-black text-slate-900">No active swaps yet</p>
                        <p class="mt-2 text-sm text-slate-500">Confirmed bookings and milestone progress will appear here.</p>
                        <Link :href="route('marketplace')" class="mt-5 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-indigo-700">
                            Browse marketplace
                        </Link>
                    </div>
                </div>

                <aside class="space-y-6">
                    <section class="motion-card border border-slate-200 bg-white">
                        <div class="border-b border-slate-100 p-5">
                            <h2 class="text-lg font-black text-slate-950">Your pending requests</h2>
                            <p class="mt-1 text-sm text-slate-500">Requests you sent to other members.</p>
                        </div>

                        <div v-if="pendingLearning.length" class="divide-y divide-slate-100">
                            <div v-for="booking in pendingLearning" :key="booking.id" class="p-5">
                                <p class="font-bold text-slate-900">{{ booking.skill?.title ?? 'Skill swap' }}</p>
                                <p class="mt-1 text-sm text-slate-500">Waiting for {{ booking.mentor?.name ?? 'mentor' }}</p>
                                <button type="button" class="mt-3 text-sm font-bold text-red-600" @click="updateBookingStatus(booking, 'cancelled')">
                                    Cancel request
                                </button>
                            </div>
                        </div>

                        <div v-else class="p-5 text-sm text-slate-500">
                            You do not have pending outgoing requests.
                        </div>
                    </section>

                    <section class="motion-card border border-slate-200 bg-white p-5">
                        <h2 class="text-lg font-black text-slate-950">Quick actions</h2>
                        <div class="mt-4 space-y-3">
                            <Link :href="route('marketplace')" class="block rounded-md border border-slate-200 p-4 font-bold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                Browse marketplace
                            </Link>
                            <Link :href="route('skills.create')" class="block rounded-md border border-slate-200 p-4 font-bold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                Post a skill
                            </Link>
                            <Link :href="route('skills.my')" class="block rounded-md border border-slate-200 p-4 font-bold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                Manage skills
                            </Link>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </DashboardLayout>
</template>
