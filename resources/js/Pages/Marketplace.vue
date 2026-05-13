<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    skills: Array
});
</script>

<template>
    <Head title="Marketplace" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Skill Marketplace</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="skill in skills" :key="skill.id" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col justify-between border border-gray-100">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                    {{ skill.user.name.substring(0, 2).toUpperCase() }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ skill.user.name }}</span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ skill.title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ skill.description }}</p>
                            
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold" 
                                  :class="skill.type === 'offering' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'">
                                {{ skill.type === 'offering' ? 'Wants to Teach' : 'Wants to Learn' }}
                            </span>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-50">
                            <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                Propose a Swap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>