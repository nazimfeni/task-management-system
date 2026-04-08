<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Receive task from controller
const props = defineProps({
    task: Object,
});

// Form setup
const form = useForm({
    title: props.task.title,
    description: props.task.description,
    status: props.task.status,
});

// Submit update
const submit = () => {
    form.put(`/tasks/${props.task.id}`);
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Edit Task</h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Title
                    </label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    />
                    <div v-if="form.errors.title" class="text-red-500 text-sm">
                        {{ form.errors.title }}
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    ></textarea>
                    <div
                        v-if="form.errors.description"
                        class="text-red-500 text-sm"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Status
                    </label>
                    <select
                        v-model="form.status"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    >
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-4">
                    <a href="/tasks" class="text-gray-600 hover:text-gray-900">
                        ← Back
                    </a>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        :disabled="form.processing"
                    >
                        Update Task
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
