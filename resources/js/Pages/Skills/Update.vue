<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    console.log("Skill ID is:", props.skill.id); // Check your browser console!
   form.patch(route('skills.update', props.skill.id))
};


</script>

<template>
    <Head title="Update Skill" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Skill</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6 max-w-xl">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Skill Title</label>
                            <input v-model="form.title" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Laravel Tutoring">
                            <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Category</label>
                            <select v-model="form.category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select a category</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Marketing">Marketing</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">I am...</label>
                            <div class="flex gap-4 mt-2">
                                <label><input type="radio" v-model="form.type" value="offering"> Offering this skill</label>
                                <label><input type="radio" v-model="form.type" value="seeking"> Seeking this skill</label>
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea v-model="form.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4"></textarea>
                        </div>

                        <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:opacity-50">
                            Update Skill
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>