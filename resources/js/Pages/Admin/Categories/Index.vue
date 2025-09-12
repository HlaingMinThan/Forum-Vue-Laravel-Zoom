<template>
  <div class="space-y-6">
    <h1 class="text-2xl font-semibold">Categories</h1>

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="font-medium">All Categories</div>
          <div class="text-sm text-gray-500">Total: {{ $page.props.categories.length }}</div>
        </div>
      </div>

      <div v-if="$page.props.categories.length === 0" class="px-6 py-12 text-center">
        <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v9A2.25 2.25 0 0118.75 18.75H5.25A2.25 2.25 0 013 16.5v-9z" />
          </svg>
        </div>
        <p class="text-gray-600">No categories found.</p>
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full text-left align-middle">
          <thead class="bg-gray-50 text-gray-600 text-sm">
            <tr>
              <th class="px-6 py-3 font-medium">Name</th>
              <th class="px-6 py-3 font-medium">Slug</th>
              <th class="px-6 py-3 font-medium">Threads</th>
              <th class="px-6 py-3 font-medium">Created</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr v-for="cat in $page.props.categories" :key="cat.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="font-medium text-gray-900">{{ cat.name }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5 text-xs font-medium">{{ cat.slug }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-md bg-emerald-50 text-emerald-700 px-2 py-1 text-xs font-semibold">{{ cat.threads_count ?? cat.threadsCount ?? 0 }}</span>
              </td>
              <td class="px-6 py-4 text-gray-600 text-sm">
                {{ formatDate(cat.created_at) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    formatDate(value) {
      if (!value) return '-';
      try { return new Date(value).toLocaleString(); } catch { return String(value); }
    }
  }
}
</script>

<style>
</style>