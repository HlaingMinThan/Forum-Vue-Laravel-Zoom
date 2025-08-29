<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Top cover / banner -->
    <div class="h-40 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-12">
      <!-- Profile header card -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
          <div class="flex items-start gap-4">
            <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-500 text-white flex items-center justify-center text-3xl font-semibold shadow">
              {{ (user?.name || 'U').charAt(0).toUpperCase() }}
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">{{ user?.name || 'Unnamed User' }}</h1>
              <p class="text-sm text-gray-500">@{{ user?.username || 'username' }}</p>
              <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-600">
                <span class="inline-flex items-center gap-1">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0V10M7 20V10m5 10V10"/>
                  </svg>
                  Joined {{ formatDate(user?.created_at) }}
                </span>
                <span>•</span>
                <span class="inline-flex items-center gap-1">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 111.657-1.657z"/>
                  </svg>
                  {{ user?.location || 'Somewhere on Earth' }}
                </span>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50">Message</button>
            <button class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Follow</button>
          </div>
        </div>

        <!-- Quick stats -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="rounded-lg border bg-gray-50 p-4">
            <p class="text-xs font-medium text-gray-500">Threads</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.threads }}</p>
          </div>
          <div class="rounded-lg border bg-gray-50 p-4">
            <p class="text-xs font-medium text-gray-500">Comments</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.comments }}</p>
          </div>
          <div class="rounded-lg border bg-gray-50 p-4">
            <p class="text-xs font-medium text-gray-500">Reputation</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.reputation }}</p>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- About / Bio -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-sm font-semibold text-gray-900">About</h2>
            <p class="mt-3 text-sm leading-relaxed text-gray-700 whitespace-pre-wrap">
              {{ user?.bio || 'This user hasn\'t added a bio yet.' }}
            </p>
            <div class="mt-6 space-y-3 text-sm">
              <div class="flex items-center gap-3 text-gray-700">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>{{ user?.email || 'hidden@email.com' }}</span>
              </div>
              <div class="flex items-center gap-3 text-gray-700">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 8l9 4 9-4"/>
                </svg>
                <span>{{ user?.website || 'example.com' }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Activity / Threads -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
              <h2 class="text-sm font-semibold text-gray-900">Recent Threads</h2>
            </div>
            <div v-if="recentThreads.length === 0" class="p-6 text-sm text-gray-500">No threads yet.</div>
            <ul v-else class="divide-y">
              <li v-for="thread in recentThreads" :key="thread.id" class="p-6">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-gray-900 font-medium">{{ thread.title }}</p>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ thread.excerpt }}</p>
                    <div class="mt-2 text-xs text-gray-500">{{ formatDate(thread.created_at) }}</div>
                  </div>
                  <a :href="`/threads/${thread.id}`" class="shrink-0 inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100">View</a>
                </div>
              </li>
            </ul>
          </div>

          <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
              <h2 class="text-sm font-semibold text-gray-900">Recent Activity</h2>
            </div>
            <ul class="divide-y">
              <li v-for="item in recentActivity" :key="item.id" class="p-6">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center">
                    <svg v-if="item.type === 'comment'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5zm0-10l9-5-9-5-9 5 9 5z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm text-gray-800">
                      <span class="font-medium">{{ user?.name || 'User' }}</span>
                      <span v-if="item.type === 'comment'"> commented on </span>
                      <span v-else> started a thread </span>
                      <a :href="`/threads/${item.thread_id}`" class="text-blue-600 hover:underline">{{ item.thread_title }}</a>
                    </p>
                    <p class="mt-1 text-xs text-gray-500">{{ formatDate(item.created_at) }}</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: false,
      default: () => ({})
    },
    stats: {
      type: Object,
      required: false,
      default: () => ({ threads: 0, comments: 0, reputation: 0 })
    },
    recentThreads: {
      type: Array,
      required: false,
      default: () => []
    },
    recentActivity: {
      type: Array,
      required: false,
      default: () => []
    }
  },
  methods: {
    formatDate(dateString) {
      if (!dateString) return 'Unknown'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  line-clamp: 2;
  overflow: hidden;
}
</style>