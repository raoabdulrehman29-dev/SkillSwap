<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    skills: {
        type: Array,
        default: () => [],
    },
});

const selectedSkill = ref(null);

const form = useForm({
    skill_id: null,
    start_time: '',
    end_time: '',
    milestones: [
        { title: '', description: '' },
    ],
});

const modalTitle = computed(() => {
    if (!selectedSkill.value) return 'Request a SkillSwap';

    return selectedSkill.value.type === 'offering'
        ? `Learn ${selectedSkill.value.title}`
        : `Teach ${selectedSkill.value.title}`;
});

const openBookingForm = (skill) => {
    selectedSkill.value = skill;
    form.clearErrors();
    form.skill_id = skill.id;
    form.start_time = '';
    form.end_time = '';
    form.milestones = [{ title: '', description: '' }];
};

const closeBookingForm = () => {
    selectedSkill.value = null;
    form.clearErrors();
};

const addMilestone = () => {
    form.milestones.push({ title: '', description: '' });
};

const removeMilestone = (index) => {
    if (form.milestones.length === 1) return;
    form.milestones.splice(index, 1);
};

const submitBooking = () => {
    form.post(route('bookings.store'), {
        preserveScroll: true,
        onSuccess: closeBookingForm,
    });
};
</script>

<template>
    <Head title="Marketplace" />

    <DashboardLayout
        title="Skill Marketplace"
        subtitle="Find people to learn from, teach, and swap skills with."
    >
        <div v-if="skills.length === 0" class="motion-card border border-slate-200 bg-white p-8 text-center">
            <p class="text-lg font-black text-slate-900">No marketplace skills yet</p>
            <p class="mt-2 text-sm text-slate-500">When members post skills, they will appear here.</p>
        </div>

        <div v-else class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            <article
                v-for="skill in skills"
                :key="skill.id"
                class="motion-card flex min-h-72 flex-col justify-between border border-slate-200 bg-white p-6"
            >
                <div>
                    <div class="mb-4 flex items-center gap-3">
                        <div class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-100 text-xs font-black text-indigo-700">
                            {{ skill.user.name.substring(0, 2).toUpperCase() }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ skill.user.name }}</p>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ skill.category }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-black text-slate-950">{{ skill.title }}</h3>
                    <p class="mt-2 line-clamp-4 text-sm text-slate-600">{{ skill.description }}</p>

                    <span
                        class="mt-4 inline-flex rounded-md px-3 py-1 text-xs font-bold"
                        :class="skill.type === 'offering' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700'"
                    >
                        {{ skill.type === 'offering' ? 'Available to teach' : 'Looking for a teacher' }}
                    </span>
                </div>

                <button
                    type="button"
                    class="mt-6 rounded-md bg-indigo-600 py-2.5 font-bold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700"
                    @click="openBookingForm(skill)"
                >
                    Propose a Swap
                </button>
            </article>
        </div>

        <div
            v-if="selectedSkill"
            class="fixed inset-0 z-50 grid place-items-center bg-slate-950/50 p-4 backdrop-blur-sm"
            @click.self="closeBookingForm"
        >
            <section class="w-full max-w-2xl overflow-hidden rounded-lg bg-white shadow-2xl">
                <header class="border-b border-slate-100 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-indigo-600">Booking request</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-950">{{ modalTitle }}</h2>
                            <p class="mt-2 text-sm text-slate-500">Add a time window and the milestones that define success.</p>
                        </div>
                        <button
                            type="button"
                            class="grid h-9 w-9 place-items-center rounded-md border border-slate-200 text-slate-500 transition hover:bg-slate-100"
                            @click="closeBookingForm"
                        >
                            x
                        </button>
                    </div>
                </header>

                <form class="max-h-[75vh] space-y-5 overflow-y-auto p-6" @submit.prevent="submitBooking">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-bold text-slate-700">Start time</label>
                            <input v-model="form.start_time" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p v-if="form.errors.start_time" class="mt-1 text-sm text-red-600">{{ form.errors.start_time }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700">End time</label>
                            <input v-model="form.end_time" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p v-if="form.errors.end_time" class="mt-1 text-sm text-red-600">{{ form.errors.end_time }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="font-black text-slate-900">Milestones</h3>
                            <button type="button" class="rounded-md border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700 transition hover:border-indigo-200 hover:text-indigo-700" @click="addMilestone">
                                Add milestone
                            </button>
                        </div>

                        <div
                            v-for="(milestone, index) in form.milestones"
                            :key="index"
                            class="rounded-md border border-slate-200 p-4"
                        >
                            <div class="flex items-center justify-between gap-3">
                                <label class="block text-sm font-bold text-slate-700">Milestone {{ index + 1 }}</label>
                                <button
                                    type="button"
                                    class="text-sm font-bold text-red-600 disabled:cursor-not-allowed disabled:opacity-40"
                                    :disabled="form.milestones.length === 1"
                                    @click="removeMilestone(index)"
                                >
                                    Remove
                                </button>
                            </div>
                            <input v-model="milestone.title" type="text" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Build login page">
                            <textarea v-model="milestone.description" class="mt-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" placeholder="Optional details"></textarea>
                            <p v-if="form.errors[`milestones.${index}.title`]" class="mt-1 text-sm text-red-600">
                                {{ form.errors[`milestones.${index}.title`] }}
                            </p>
                        </div>

                        <p v-if="form.errors.milestones" class="text-sm text-red-600">{{ form.errors.milestones }}</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                        <button type="button" class="rounded-md border border-slate-200 px-4 py-2 font-bold text-slate-700 transition hover:bg-slate-100" @click="closeBookingForm">
                            Cancel
                        </button>
                        <button type="submit" :disabled="form.processing" class="rounded-md bg-indigo-600 px-4 py-2 font-bold text-white transition hover:bg-indigo-700 disabled:opacity-50">
                            Send request
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </DashboardLayout>
</template>
