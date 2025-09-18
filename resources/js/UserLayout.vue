<template>
    <div class="min-h-screen bg-gray-50">
      <!-- Header -->
      <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center py-4">
            <Link :href="route('home')" class="flex items-center">
              <h1 class="text-2xl font-bold text-gray-900">Creative Coder</h1>
            </Link>
            <div class="flex items-center space-x-4">
              <!-- only after login -->
              <Link v-if="$page.props.auth.user" href="/new-thread" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                New Thread
              </Link>
              <div class="relative">
                <input 
                  type="text" 
                  placeholder="Search forums..." 
                  class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  v-model="search"
                >
              </div>
              <template v-if="!$page.props.auth.user">
                <Link href="/login" class="border-blue-600  border text-black px-4 py-2 rounded-lg font-medium transition-colors">
                  Login
                </Link>
                <Link href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                  Register
                </Link>
              </template>

              <template v-else>
                <Link v-if="$page.props.auth.user" 
                 href="/logout"
                  method="post"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Logout
              </Link>
              </template>
            </div>
          </div>
        </div>
      </header>
  
      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
          <!-- Left Sidebar - Categories -->
          <div class="w-80 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
              <!-- Categories Header -->
              <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Categories</h2>
              </div>
              
              <!-- Categories List -->
              <div class="p-4">
                <div class="space-y-2">
                  <Link :href="'/?category='+category.slug" v-for="category in $page.props.categories" :key="category.id" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                    <div class="flex items-center space-x-3">
                      <!-- <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                          <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                        </svg>
                      </div> -->
                      <div>
                        <h3 class="font-medium text-gray-900">{{category.name}}</h3>
                        <p class="text-sm text-gray-500">{{category.description}}</p>
                      </div>
                    </div>
                    <span class="text-sm text-gray-400">1.2k</span>
                  </Link>
  
                </div>
              </div>
            </div>
  
            <!-- Popular Tags -->
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
              <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Popular Tags</h3>
              </div>
              <div class="p-4">
                <div class="flex flex-wrap gap-2">
                  <Link :href="route('home',{
                    tag : tag.slug
                  })" v-for="tag in $page.props.tags"  :key="tag.id" class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">#{{tag.name}}</Link>
                  
                </div>
              </div>
            </div>
          </div>
  
          <!-- Right Side - Forum Threads -->
          <div class="flex-1">
            <slot />
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import { Link } from '@inertiajs/vue3';

  
  export default {
    name: 'Home',
    components : {Link},
    props : {
      threads : {
        type : Array
      }
    },
    data() {
      return {
        search : ""
      }
    },
    watch : {
      search(){
        this.$inertia.visit(route('home', {
          search : this.search
        }));
      }
    },
    mounted(){
      console.log();
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