<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    skill: Object,
});

const form = useForm({
    title: props.skill.title,
    description: props.skill.description,
    category: props.skill.category,
    type: props.skill.type,
});

const submit = () => {
    form.patch(route('skills.update', props.skill.id));
};
</script>

<template>
    <Head title="Update Skill" />

    <DashboardLayout
        title="Update Skill"
        subtitle="Keep your listing clear so better matches can find you."
    >
        <div class="motion-card border border-slate-200 bg-white p-6">
            <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Skill Title</label>
                    <input v-model="form.title" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Laravel Tutoring">
                    <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select v-model="form.category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a category</option>
                        <option value="Web Development">Web Development</option>
                        <option value="Graphic Design">Graphic Design</option>
                        <option value="Marketing">Marketing</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">I am...</label>
                    <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label
                            class="rounded-md border p-4 transition"
                            :class="form.type === 'offering' ? 'border-indigo-500 bg-indigo-50' : 'border-slate-200'"
                        >
                            <input type="radio" v-model="form.type" value="offering" class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 font-semibold text-slate-800">Offering this skill</span>
                        </label>
                        <label
                            class="rounded-md border p-4 transition"
                            :class="form.type === 'seeking' ? 'border-indigo-500 bg-indigo-50' : 'border-slate-200'"
                        >
                            <input type="radio" v-model="form.type" value="seeking" class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 font-semibold text-slate-800">Seeking this skill</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4"></textarea>
                </div>

                <button type="submit" :disabled="form.processing" class="rounded-md bg-indigo-600 px-4 py-2 font-bold text-white transition hover:bg-indigo-700 disabled:opacity-50">
                    Update Skill
                </button>
            </form>
        </div>
    </DashboardLayout>
</template>
