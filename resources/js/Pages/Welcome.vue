<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome" />

    <main class="min-h-screen bg-gray-50">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <h1 class="text-2xl font-bold text-indigo-600">SkillSwap</h1>

            <div v-if="canLogin" class="flex items-center gap-4">
                <Link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                    Log in
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                >
                    Register
                </Link>
            </div>
        </nav>

        <section class="mx-auto grid min-h-[70vh] max-w-7xl place-items-center px-6 text-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Learn. Teach. Trade skills.</p>
                <h2 class="mt-4 text-4xl font-bold text-gray-900 sm:text-5xl">Welcome to SkillSwap</h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    Connect with people who can teach what you want to learn, and share the skills you already have.
                </p>
            </div>
        </section>
    </main>
</template>
