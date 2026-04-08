<script setup>
import { useForm, Link, Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineOptions({
    layout: AuthenticatedLayout
});

const form = useForm({
    title: "",
    description: ""
});

const submit = () => {
    form.post("/tasks");
};
</script>

<template>
  <Head title="Create Task" />

  <div class="max-w-3xl mx-auto mt-6 p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Create Task</h1>
      <Link href="/tasks" class="text-sm text-gray-600 hover:text-gray-900">← Back to Tasks</Link>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input
            v-model="form.title"
            type="text"
            placeholder="Enter task title"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
          />
          <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
          <textarea
            v-model="form.description"
            rows="4"
            placeholder="Enter task description"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
          ></textarea>
          <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition disabled:opacity-50"
          >
            <span v-if="form.processing">Creating...</span>
            <span v-else>Create Task</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
