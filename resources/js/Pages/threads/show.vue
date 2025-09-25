<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-4">
          <Link prefetch="mount" href="/" class="text-gray-500 hover:text-gray-700 transition-colors">
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
          <div class=" max-w-none">
            <div class=" text-gray-800 prose">
              <VueMarkdown :source="thread.body"/>
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

      <!-- Comments -->
      <div class="mt-6">
        <!-- Comment Form (design only) -->
        <form 
          @submit.prevent="saveComment"
         class="bg-white rounded-lg shadow-sm border p-6">
          <h3 class="text-lg font-semibold text-gray-900">Comments</h3>
          <div class="mt-4 flex items-start space-x-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-sky-500 text-white flex items-center justify-center font-semibold">
                U
              </div>
            </div>
            <div class="flex-1">
              <div class="relative">
                <v-md-editor v-model="commentBody" height="200px"></v-md-editor>
                <div class="mt-2 flex items-center justify-between">
                  <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <span>{{ charCount }}/1000</span>
                  </div>
                  <div class="space-x-2">
                    <button type="button" class="inline-flex items-center px-3 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                      Cancel
                    </button>
                    <button type="submit" :disabled="!commentBody.trim()" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                      Post comment
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <!-- Comment List (design only) -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border divide-y">
          <div v-if="thread.comments?.length === 0" class="p-6 text-center text-gray-500">
            No comments yet. Be the first to share your thoughts!
          </div>
          <div v-for="comment in comments" :key="comment.id" class="p-6" :id="'comment-' + comment.id">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                <Link :href="route('users.show',comment.user.id)" class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-semibold">
                  {{ comment.user.name.charAt(0).toUpperCase() }}
                </Link>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ comment.user.name }}</p>
                    <p class="text-xs text-gray-500">{{ comment.time }}</p>
                  </div>
                </div>
                <div class="mt-3 text-gray-800 leading-relaxed">
                  <div v-if="editingId === comment.id">
                    <Form :action="`/comments/${comment.id}/update`" method="put" :options="{
                      preserveScroll:true,
                      onSuccess: () => {
                        cancelEdit()
                      },
                    }">
                      <textarea
                        name="body"
                        v-model="editedText"
                        rows="4"
                        maxlength="1000"
                        class="w-full resize-y rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 px-4 py-3 text-gray-800 placeholder:text-gray-400"
                      ></textarea>
                      <div class="mt-2 flex items-center justify-end space-x-2">
                        <div >
                        <button @click="cancelEdit" type="button" class="inline-flex items-center px-3 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                          <button type="submit" :disabled="!editedText.trim()" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
                        </div>
                      </div>
                    </Form>
                  </div>
                  <div v-else class="whitespace-pre-wrap prose">
                    <vue-markdown :source="comment.body"/>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-4 text-sm text-gray-600">
                  <button class="inline-flex items-center space-x-1 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Reply</span>
                  </button>
                  <button class="inline-flex items-center space-x-1 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>Like</span>
                  </button>
                  <template v-if="editingId === comment.id">
                    <button @click="cancelEdit" class="inline-flex items-center space-x-1 hover:text-gray-900">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                      <span>Cancel</span>
                    </button>
                    <button @click="saveEdit" :disabled="!editedText.trim()" class="inline-flex items-center space-x-1 text-blue-600 hover:text-blue-700 disabled:opacity-50">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      <span>Save</span>
                    </button>
                  </template>
                  <button v-else-if="comment.commentActionAuthorize" @click="startEdit(comment)" class="inline-flex items-center space-x-1 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h12M6 6h12M6 18h12"></path>
                    </svg>
                    <span>Edit</span>
                  </button>
                  <Form 
                  v-if="comment.commentActionAuthorize"
                  :options="{
                    preserveScroll : true
                  }"
                  :action="`/comments/${comment.id}/destroy`" method="delete">
                    <button type="submit" class="inline-flex items-center space-x-1 text-red-500
                  hover:text-gray-900">
                    
                    <span>delete</span>
                  </button>
                  </Form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePoll, Form, router } from '@inertiajs/vue3'
import VueMarkdown from 'vue-markdown-render'


const props = defineProps({
  thread: {
    type: Object,
    required: true
  },
  comments: {
    type: Array,
    required: true
  },
})

usePoll(5000,{
  only : ['comments']
})

const commentBody = ref('')
// const localComments = ref([...props.comments])
const editingId = ref(null)
const editedText = ref('')

const charCount = computed(() => commentBody.value.length)

const saveComment = async() => {
  await router.post(`/threads/${props.thread.id}/comments/store`, {
    body : commentBody.value
  }, {
    preserveScroll:true
  })
  
  commentBody.value = "";
}

const formatDate = (dateString) => {
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

function startEdit(comment){
  editingId.value = comment.id
  editedText.value = comment.body
}

function cancelEdit(){
  editingId.value = null
  editedText.value = ''
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