<template>
  <!-- Threads Header -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
              <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Threads</h2>
                <div class="flex items-center space-x-2">
                  <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Latest</option>
                    <option>Most Popular</option>
                    <option>Most Replies</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Threads List -->
          <div class="space-y-4">
            <!-- Thread Item 1 -->
            <div v-for="thread in threads" :key="thread.id" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
              <div class="p-6">
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                      <span class="text-blue-600 font-semibold">JD</span>
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-2 mb-2">
                      <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{thread.category?.name}}</span>
                      <span class="text-sm text-gray-500">{{ moment(thread.created_at,"YYYYMMDD").fromNow() }}</span>
                    </div>
                    <Link :href="'/threads/'+thread.id" class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">
                      {{thread.title}}
                    </Link>
                    <p class="text-gray-600 mb-3 line-clamp-2">
                      {{thread.body}}...
                    </p>
                    <div class="flex items-center justify-between">
                      <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center space-x-1">
                          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                          </svg>
                          <span>24 replies</span>
                        </span>
                        <span class="flex items-center space-x-1">
                          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                          </svg>
                          <span>1.2k views</span>
                        </span>
                      </div>
                      <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">by</span>
                        <span class="text-sm font-medium text-gray-900">John Doe</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        
          </div>

          <!-- Pagination -->
          <div class="mt-8 flex items-center justify-between">
            <div class="text-sm text-gray-500">
              Showing 1 to 4 of 24 threads
            </div>
            <div class="flex items-center space-x-2">
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                Previous
              </button>
              <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">1</button>
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">2</button>
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">3</button>
              <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">Next</button>
            </div>
          </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import moment from 'moment';

export default {
  components:{Link},
  name: 'Home',
  props : {
    threads : {
      type : Array
    }
  },
  data() {
    return {
      // Add reactive data here if needed
    }
  },
  methods:{ moment },
  mounted(){
    console.log(this.threads);
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>