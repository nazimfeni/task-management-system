<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
      <div class="font-bold text-lg">TaskApp</div>
      <div class="space-x-4">
        <Link href="/dashboard" class="hover:text-gray-300">Dashboard</Link>
        <Link href="/tasks" class="hover:text-gray-300">Tasks</Link>
        <Link href="/logout" method="post" class="hover:text-gray-300">Logout</Link>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
