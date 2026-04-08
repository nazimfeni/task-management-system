<script setup>
import { Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({ tasks: Array });

// Delete function
const deleteTask = (id) => {
    if (confirm("Are you sure you want to delete this task?")) {
        router.delete(`/tasks/${id}`);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Task Management</h1>

                <Link
                    href="/tasks/create"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition"
                >
                    + Create Task
                </Link>
            </div>

            <!-- Task Table -->
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="task in tasks"
                            :key="task.id"
                            class="border-b hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ task.title }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-semibold"
                                    :class="{
                                        'bg-gray-200 text-gray-700': task.status === 'draft',
                                        'bg-blue-100 text-blue-700': task.status === 'in_progress',
                                        'bg-yellow-100 text-yellow-700': task.status === 'completed',
                                        'bg-green-100 text-green-700': task.status === 'approved',
                                    }"
                                >
                                    {{ task.status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 flex gap-3">
                                <Link
                                    :href="`/tasks/${task.id}/edit`"
                                    class="text-blue-600 hover:underline"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="$inertia.delete(`/tasks/${task.id}`)"
                                    class="text-red-600 hover:underline"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="tasks.length === 0">
                            <td colspan="3" class="text-center py-6 text-gray-500">
                                No tasks found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
