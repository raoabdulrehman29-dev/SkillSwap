<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    skills: Array
});
</script>

<template>
    <Head title="My Skills" />

    <DashboardLayout
        title="My Skills"
        subtitle="Manage the skills you are offering or hoping to learn."
    >
        <template #actions>
            <Link :href="route('skills.create')" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700">
                Add Skill
            </Link>
        </template>

        <div v-if="skills.length === 0" class="motion-card border border-slate-200 bg-white p-8 text-center">
            <p class="text-lg font-black text-slate-900">You have not posted any skills yet.</p>
            <p class="mt-2 text-sm text-slate-500">Add your first skill to start matching with the community.</p>
        </div>

        <div v-else class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                    <div v-for="skill in skills" :key="skill.id" class="motion-card bg-white p-6 border border-slate-200 border-l-4" 
                         :class="skill.type === 'offering' ? 'border-l-green-500' : 'border-l-blue-500'">
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
    </DashboardLayout>
</template>
