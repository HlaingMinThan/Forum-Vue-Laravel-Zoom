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
                    <Link :href="route('threads.show',thread.id)" class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">
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
                      <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2">
                          <span class="text-sm text-gray-500">by</span>
                          <span class="text-sm font-medium text-gray-900">{{thread.user.name}}</span>
                        </div>
                        <Link
                        :href="route('threads.edit',thread.id)"
                        v-if="$page.props.auth?.user && thread.threadActionAuthorize"
                          class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors"
                        >
                          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                          </svg>
                          <span class="hidden sm:inline">Edit</span>
                        </Link>
                        <button
                        v-if="$page.props.auth?.user && thread.threadActionAuthorize"
                          type="button"
                          class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors"
                          @click="openDeleteModal(thread)"
                        >
                          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                          </svg>
                          <span class="hidden sm:inline">Delete</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        
          </div>

          <!-- Delete Confirmation Modal -->
          <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <div class="p-6">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 100 18 9 9 0 000-18z" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Delete thread</h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">
                      Are you sure you want to delete
                      <span class="font-semibold text-gray-700">"{{ threadToDelete?.title }}"</span>?
                      This action cannot be undone.
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse sm:space-x-reverse sm:space-x-3">
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
import Modal from '@/Components/Modal.vue';
import moment from 'moment';

export default {
  components:{Link, Modal},
  name: 'Home',
  props : {
    threads : {
      type : Array
    }
  },
  data() {
    return {
      showDeleteModal: false,
      threadToDelete: null,
    }
  },
  methods:{
    moment,
    openDeleteModal(thread){
      this.threadToDelete = thread;
      this.showDeleteModal = true;
    },
    closeDeleteModal(){
      this.showDeleteModal = false;
      this.threadToDelete = null;
    },
    confirmDelete(){
      this.$inertia.delete(route('threads.destroy',this.threadToDelete.id));
      this.closeDeleteModal();
    }
  },
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