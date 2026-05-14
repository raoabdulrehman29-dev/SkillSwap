<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
    subtitle: {
        type: String,
        default: '',
    },
});

const page = usePage();
const showMobileMenu = ref(false);

const user = computed(() => page.props.auth?.user ?? {});
const reputation = computed(() => user.value.repotation ?? 0);
const initials = computed(() => {
    const name = user.value.name ?? 'SkillSwap';
    return name
        .split(' ')
        .map((part) => part[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
});

const navItems = [
    { label: 'Dashboard', route: 'dashboard', icon: 'home', active: ['dashboard'] },
    { label: 'Marketplace', route: 'marketplace', icon: 'briefcase', active: ['marketplace'] },
    { label: 'My Skills', route: 'skills.my', icon: 'grid', active: ['skills.my'] },
    { label: 'Add Skill', route: 'skills.create', icon: 'plus', active: ['skills.create', 'skills.edit'] },
    { label: 'Profile', route: 'profile.edit', icon: 'user', active: ['profile.edit'] },
];

const isActive = (item) => item.active.some((name) => route().current(name));
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-72 flex-col border-r border-slate-200 bg-white lg:flex">
            <div class="flex h-20 items-center px-6">
                <Link :href="route('dashboard')" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-600 text-lg font-black text-white shadow-sm shadow-indigo-200">
                        S
                    </span>
                    <span>
                        <span class="block text-xl font-black text-slate-950">SkillSwap</span>
                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-400">Member workspace</span>
                    </span>
                </Link>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-4">
                <Link
                    v-for="item in navItems"
                    :key="item.route"
                    :href="route(item.route)"
                    class="dashboard-nav-link group"
                    :class="isActive(item)
                        ? 'bg-indigo-50 text-indigo-700 shadow-sm'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950'"
                >
                    <span class="grid h-9 w-9 place-items-center rounded-lg transition duration-200"
                        :class="isActive(item) ? 'bg-white text-indigo-600 shadow-sm' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:text-slate-800'">
                        <svg v-if="item.icon === 'home'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 11.5 12 4l9 7.5M5 10v10h5v-6h4v6h5V10" />
                        </svg>
                        <svg v-else-if="item.icon === 'briefcase'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V6a3 3 0 0 1 3-3 3 3 0 0 1 3 3v1m-9 4h12M5 7h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                        </svg>
                        <svg v-else-if="item.icon === 'grid'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z" />
                        </svg>
                        <svg v-else-if="item.icon === 'plus'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                        </svg>
                        <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                        </svg>
                    </span>
                    <span class="font-semibold">{{ item.label }}</span>
                </Link>
            </nav>

            <div class="m-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="grid h-11 w-11 place-items-center rounded-lg bg-indigo-600 text-sm font-black text-white">
                        {{ initials }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-slate-900">{{ user.name ?? 'SkillSwap user' }}</p>
                        <p class="text-sm font-semibold text-indigo-600">{{ reputation }} XP</p>
                    </div>
                </div>
                <Link :href="route('logout')" method="post" as="button" class="mt-4 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                    Log out
                </Link>
            </div>
        </aside>

        <div class="lg:pl-72">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex min-h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-wide text-indigo-600">Welcome back, {{ user.name ?? 'there' }}</p>
                        <h1 class="mt-1 truncate text-2xl font-black text-slate-950">{{ title }}</h1>
                        <p v-if="subtitle" class="mt-1 text-sm text-slate-500">{{ subtitle }}</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <slot name="actions" />
                        <div class="hidden items-center gap-2 rounded-lg border border-indigo-100 bg-indigo-50 px-3 py-2 sm:flex">
                            <span class="text-sm font-black text-indigo-700">{{ reputation }} XP</span>
                        </div>
                        <button
                            type="button"
                            class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 lg:hidden"
                            @click="showMobileMenu = !showMobileMenu"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="!showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <nav class="scrollbar-hide flex gap-2 overflow-x-auto border-t border-slate-100 px-4 py-3 sm:px-6 lg:hidden">
                    <Link
                        v-for="item in navItems"
                        :key="item.route"
                        :href="route(item.route)"
                        class="shrink-0 rounded-md px-3 py-2 text-sm font-semibold transition"
                        :class="isActive(item) ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    >
                        {{ item.label }}
                    </Link>
                </nav>
            </header>

            <main class="px-4 py-6 sm:px-6 lg:px-8">
                <section class="dashboard-page mx-auto max-w-7xl">
                    <slot />
                </section>
            </main>
        </div>
    </div>
          

</template>

<style scoped>
.dashboard-nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-radius: 0.5rem;
    padding: 0.65rem 0.75rem;
    transition: transform 180ms ease, background-color 180ms ease, color 180ms ease, box-shadow 180ms ease;
}

.dashboard-nav-link:hover {
    transform: translateX(3px);
}

.dashboard-page {
    animation: page-in 420ms ease both;
}

:deep(.motion-card) {
    border-radius: 0.5rem;
    transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
}

:deep(.motion-card:hover) {
    transform: translateY(-3px);
    box-shadow: 0 18px 35px -22px rgb(15 23 42 / 0.45);
}

@keyframes page-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
