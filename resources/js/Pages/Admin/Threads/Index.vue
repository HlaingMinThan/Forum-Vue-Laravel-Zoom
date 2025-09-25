<template>
    <div class="bg-white shadow rounded-lg p-6">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Threads</h1>
        <div class="text-sm text-gray-500">Total: {{ threads.length }}</div>
      </div>
  
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Content</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">User</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category</th>
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
              <td class="px-6 py-4 text-gray-600 text-sm">{{ thread.user?.name }}</td>
              <td class="px-6 py-4">
                <span class="px-3 py-1 text-xs  text-gray-600 rounded-full font-medium">
                  {{ thread.category?.name }}
                </span>
            </td>
              
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3'
  
  export default {
    components: { Link },
    props: {
      threads: Array,
    }
    
  }
  </script>