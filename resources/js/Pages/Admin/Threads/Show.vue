<template>
    <div class="max-w-4xl mx-auto px-6 py-8">
      <!-- Back Button -->
      <div class="mb-6">
        <Link
          href="/admin/threads"
          class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition"
        >
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            ></path>
          </svg>
          Back to threads
        </Link>
      </div>
  
      <!-- Thread Content -->
      <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ thread.title }}</h1>
  
        <!-- Meta Info -->
        <p class="text-sm text-gray-500 mb-4">
          Posted by <span class="font-semibold text-gray-700">{{ thread.user.name }}</span>
          • {{ new Date(thread.created_at).toLocaleDateString() }}
          • <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded">
            {{ thread.category.name }}
          </span>
        </p>
  
        <!-- Body -->
        <div class="bg-gray-50 p-5 rounded-md mb-4">
          <p class="text-gray-800 leading-relaxed whitespace-pre-line">
            {{ thread.body }}
          </p>
        </div>
  
        <!-- Tags -->
        <div class="text-sm text-gray-600 mb-6">
          <span class="font-semibold">Tags:</span>
          <span v-if="thread.tags.length">
            <span
              v-for="tag in thread.tags"
              :key="tag.id"
              class="inline-block ml-2 px-3 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-full"
            >
              #{{ tag.name }}
            </span>
          </span>
          <span v-else class="italic text-gray-400">No tags</span>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Link } from "@inertiajs/vue3";
  
  export default {
    components: { Link },
    props: {
      thread: Object,
    },
  };
  </script>