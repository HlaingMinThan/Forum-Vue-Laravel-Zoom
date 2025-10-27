<template>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Threads</h1>
            <div class="text-sm text-gray-500">Total: {{ threads.length }}</div>
        </div>

        <div class="overflow-x-auto">
            <table
                class="min-w-full divide-y divide-gray-200 border rounded-lg"
            >
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-sm font-semibold text-gray-600"
                        >
                            Title
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-semibold text-gray-600"
                        >
                            Content
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-semibold text-gray-600"
                        >
                            User
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-semibold text-gray-600"
                        >
                            Category
                        </th>
                        <th
                            class="px-6 py-3 text-right text-sm font-semibold text-gray-600"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr
                        v-for="thread in threads"
                        :key="thread.id"
                        class="hover:bg-gray-50 transition"
                    >
                        <td class="px-6 py-4">
                            <Link
                                :href="route('admin.threads.show', thread.id)"
                                class="text-gray-900 font-medium hover:text-indigo-600 transition"
                            >
                                {{ thread.title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <p class="line-clamp-2">{{ thread.body }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ thread.user?.name }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs text-gray-600 rounded-full font-medium"
                            >
                                {{ thread.category?.name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button
                                    type="button"
                                    class="bg-blue-500 rounded-2xl text-white py-1 px-2 text-sm"
                                    @click="
                                        route('admin.threads.edit', {
                                            id: thread.id,
                                        })
                                    "
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    class="bg-red-500 rounded-2xl text-white py-1 px-2 text-sm"
                                    @click="openDeleteModal(thread)"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <div class="p-6">
                <div class="sm:flex sm:items-start">
                    <!-- Red warning icon -->
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                    >
                        <svg
                            class="h-6 w-6 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3"
                            />
                        </svg>
                    </div>

                    <!-- Text -->
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Delete thread
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete
                                <span class="font-semibold text-gray-700"
                                    >"{{ threadToDelete?.title }}"</span
                                >? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div
                    class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse sm:space-x-reverse sm:space-x-3"
                >
                    <button
                        type="button"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto"
                        @click="confirmDelete"
                    >
                        Delete
                    </button>
                    <button
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto"
                        @click="closeDeleteModal"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";

export default {
    components: { Link, Modal },
    props: {
        threads: Array,
    },
    data() {
        return {
            showDeleteModal: false,
            threadToDelete: null,
        };
    },
    methods: {
        openDeleteModal(thread) {
            this.threadToDelete = thread;
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.threadToDelete = null;
        },
        confirmDelete() {
            this.$inertia.delete(
                this.route("admin.threads.destroy", this.threadToDelete.id)
            );
            this.closeDeleteModal();
        },
    },
};
</script>
