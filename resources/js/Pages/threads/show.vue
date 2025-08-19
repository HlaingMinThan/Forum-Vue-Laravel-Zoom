<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-4">
          <Link href="/" class="text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
          </Link>
          <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900">{{ thread.title }}</h1>
            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
              <span>Posted by {{ thread.user?.name || 'Anonymous' }}</span>
              <span>•</span>
              <span>{{ formatDate(thread.created_at) }}</span>
              <span>•</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ thread.category?.name }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-lg shadow-sm border">
        <!-- Thread Content -->
        <div class="p-6 border-b border-gray-200">
          <div class="prose prose-lg max-w-none">
            <div class="whitespace-pre-wrap text-gray-800 leading-relaxed">
              {{ thread.body }}
            </div>
          </div>
        </div>

        <!-- Thread Metadata -->
        <div class="p-6 bg-gray-50 rounded-b-lg">
          <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Tags -->
            <div class="flex flex-wrap items-center gap-2">
              <span class="text-sm font-medium text-gray-700">Tags:</span>
              <div v-if="thread.tags && thread.tags.length > 0" class="flex flex-wrap gap-2">
                <span 
                  v-for="tag in thread.tags" 
                  :key="tag.id"
                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors cursor-pointer"
                >
                  #{{ tag.name }}
                </span>
              </div>
              <span v-else class="text-sm text-gray-500 italic">No tags</span>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
              <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Reply
              </button>
              <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Like
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Author Info Card -->
      <div class="mt-6 bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center space-x-4">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
              <span class="text-white font-semibold text-lg">
                {{ thread.user?.name ? thread.user.name.charAt(0).toUpperCase() : 'A' }}
              </span>
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">
              {{ thread.user?.name || 'Anonymous User' }}
            </p>
            <p class="text-sm text-gray-500">
              Member since {{ thread.user?.created_at ? formatDate(thread.user.created_at, 'MMM YYYY') : 'Unknown' }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  components: {
    Link
  },
  props: {
    thread: {
      type: Object,
      required: true
    }
  },
  methods: {
    formatDate(dateString) {
      if (!dateString) return 'Unknown'
      
      const date = new Date(dateString)
      const now = new Date()
      const diffTime = Math.abs(now - date)
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
      
      if (diffDays === 1) {
        return 'Yesterday'
      } else if (diffDays < 7) {
        return `${diffDays} days ago`
      } else {
        return date.toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric'
        })
      }
    }
  }
}
</script>

<style scoped>
.prose {
  color: inherit;
}

.prose p {
  margin: 0;
}
</style>