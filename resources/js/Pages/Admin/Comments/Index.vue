<template>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Comments</h1>
        </div>

        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="font-medium">All Comments</div>
                    <div class="text-sm text-gray-500">
                        Total: {{ $page.props.comments.length }}
                    </div>
                </div>
            </div>

            <div
                v-if="$page.props.comments.length === 0"
                class="px-6 py-12 text-center"
            >
                <div
                    class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6 text-gray-400"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v9A2.25 2.25 0 0118.75 18.75H5.25A2.25 2.25 0 013 16.5v-9z"
                        />
                    </svg>
                </div>
                <p class="text-gray-600">No comments found.</p>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full text-left align-middle">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="px-6 py-3 font-medium">Author</th>
                            <th class="px-6 py-3 font-medium">Thread</th>
                            <th class="px-6 py-3 font-medium">Content</th>
                            <th class="px-6 py-3 font-medium">Created</th>
                            <th class="px-6 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr
                            v-for="comment in $page.props.comments"
                            :key="comment.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5 text-xs font-medium"
                                >
                                    {{ comment.author_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 text-gray-700 px-2 py-1 text-xs font-normal"
                                >
                                    {{
                                        comment.thread_title ||
                                        comment.thread?.title ||
                                        "N/A"
                                    }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 text-gray-700 px-2 py-1 text-xs font-normal"
                                >
                                    {{ comment.content }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                {{ formatDate(comment.created_at) }}
                            </td>
                            <td
                                class="px-6 py-4 text-gray-600 text-sm space-x-4 flex justify-between"
                            >
                                <Link
                                    :href="route('comments.edit', comment.id)"
                                    class="bg-blue-500 px-3 py-2 text-white rounded-2xl"
                                    >edit</Link
                                >
                                <button
                                    @click="deleteComment(comment.id)"
                                    class="bg-red-500 px-2 py-1 text-white rounded-2xl"
                                >
                                    delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";

const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
};

const deleteComment = (id) => {
    // Implement delete logic here
    if (confirm("Are you sure you want to delete this comment?")) {
        // Call API or Inertia delete route
    }
};
</script>
