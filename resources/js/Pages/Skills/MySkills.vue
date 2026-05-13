<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    skills: Array
});
</script>

<template>
    <Head title="My Skills" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Skills</h2>
                <Link :href="route('skills.create')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Add New Skill
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="skills.length === 0" class="bg-white p-6 text-center rounded-lg shadow">
                    <p class="text-gray-500">You haven't posted any skills yet.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="skill in skills" :key="skill.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4" 
                         :class="skill.type === 'offering' ? 'border-green-500' : 'border-blue-500'">
                        <div class="flex justify-between items-start">
                            <span class="text-xs font-bold uppercase tracking-widest px-2 py-1 rounded bg-gray-100">
                                {{ skill.category }}
                            </span>
                            <span :class="skill.type === 'offering' ? 'text-green-600' : 'text-blue-600'" class="text-xs font-semibold">
                                {{ skill.type === 'offering' ? 'Teaching' : 'Learning' }}
                            </span>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-gray-900">{{ skill.title }}</h3>
                        <p class="mt-2 text-gray-600 text-sm line-clamp-3">{{ skill.description }}</p>
                        
                        <div class="mt-6 flex gap-2">
                            <Link :href="route('skills.edit', skill.id)" class="text-sm text-indigo-600 hover:underline">
                                Edit
                            </Link>
                             <Link :href="route('skills.delete', skill.id)" class="text-sm text-indigo-600 hover:underline">
                                Delete
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>