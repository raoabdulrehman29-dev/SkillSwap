<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

   <div class="min-h-screen bg-gray-50 flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="p-6">
      <span class="text-2xl font-bold text-indigo-600">SkillSwap</span>
    </div>
    <nav class="flex-1 px-4 space-y-2">
      <a href="#" class="flex items-center p-3 bg-indigo-50 text-indigo-700 rounded-lg font-medium">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1  1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
      </a>
      <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg transition">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Marketplace
      </a>
    </nav>
  </aside>

<h1>ok so this is the first commit while checkign pull request</h1>

  <!-- Main Content -->
  <main class="flex-1 overflow-y-auto">
    <!-- Top Header -->
    <header class="bg-white border-b border-gray-200 p-4 flex justify-between items-center sticky top-0 z-10">
      <h1 class="text-xl font-semibold text-gray-800">Welcome back, Abdul Rehman!</h1>
      <div class="flex items-center space-x-4">
        <!-- Reputation Badge -->
        <div class="flex items-center bg-indigo-100 px-3 py-1.5 rounded-full">
          <span class="text-indigo-700 text-sm font-bold">{{ auth.user.repotation }} XP</span>
        </div>
        <div class="h-10 w-10 rounded-full bg-indigo-500 border-2 border-white shadow-sm"></div>
      </div>
    </header>

    <div class="p-8 max-w-7xl mx-auto space-y-8">
      
      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
          <p class="text-sm font-medium text-gray-500">Total Skills Listed</p>
          <h3 class="text-3xl font-bold mt-1">12</h3>
          <p class="text-green-500 text-xs mt-2 font-semibold">+2 this week</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
          <p class="text-sm font-medium text-gray-500">Active Swaps</p>
          <h3 class="text-3xl font-bold mt-1">4</h3>
          <p class="text-indigo-500 text-xs mt-2 font-semibold">2 pending approval</p>
        </div>
        <div class="bg-indigo-600 p-6 rounded-2xl shadow-lg text-white">
          <p class="text-sm font-medium text-indigo-100">Community Rank</p>
          <h3 class="text-3xl font-bold mt-1">Expert</h3>
          <div class="w-full bg-indigo-400 h-1.5 mt-4 rounded-full">
            <div class="bg-white h-1.5 rounded-full w-3/4"></div>
          </div>
        </div>
      </div>

      <!-- Main Layout: Skills & Activities -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: My Skills Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100">
          <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-800">My Skill Listings</h2>
            <button class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
              + Add New Skill
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="text-xs font-semibold text-gray-400 uppercase tracking-wider bg-gray-50">
                  <th class="px-6 py-4">Skill Name</th>
                  <th class="px-6 py-4">Status</th>
                  <th class="px-6 py-4">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4 font-medium text-gray-700">ReactJS Development</td>
                  <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-md">Live</span></td>
                  <td class="px-6 py-4 text-red-500 hover:underline cursor-pointer">Delete</td>
                </tr>
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4 font-medium text-gray-700">Tailwind UI Design</td>
                  <td class="px-6 py-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-md">Pending</span></td>
                  <td class="px-6 py-4 text-red-500 hover:underline cursor-pointer">Delete</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right: Recent Reputation Gains -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
          <div class="p-6 border-b border-gray-50">
            <h2 class="font-bold text-gray-800">Recent Activity</h2>
          </div>
          <div class="p-6 space-y-6">
            <div class="flex items-start">
              <div class="p-2 bg-green-100 rounded-lg mr-4">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-800">Added New Skill</p>
                <p class="text-xs text-gray-500">+20 XP Earned</p>
              </div>
            </div>
            <div class="flex items-start">
              <div class="p-2 bg-indigo-100 rounded-lg mr-4">
                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-800">Helpful Answer</p>
                <p class="text-xs text-gray-500">+10 XP Earned</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
</div>

</template>
