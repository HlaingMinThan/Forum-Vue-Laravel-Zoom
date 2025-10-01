<template>
  <div class="min-h-screen flex bg-gray-100">
    <aside class="w-64 bg-white border-r">
      <div class="p-5 font-extrabold text-2xl tracking-tight">Admin</div>
      <nav class="px-3 space-y-1">
        <Link
          v-for="item in navItems"
          :key="item.href"
          :href="item.href"
          :class="[
            'block px-3 py-2.5 rounded-md text-[15px] md:text-base font-medium',
            item.href === currrentPath ? 'bg-gray-900 text-white' : 'text-gray-800 hover:bg-gray-100'
          ]"
        >
          {{ item.title }}
        </Link>
      </nav>
    </aside>
    <main class="flex-1">
      <section class="max-w-7xl mx-auto px-4 py-6">
        <slot />
      </section>
    </main>
  </div>
</template>

<script>
 import { Link } from '@inertiajs/vue3';
 
 export default {
   components: {Link},
   data() {
    return {
      navItems : [
         { title: 'Dashboard', href: '/admin' },
         { title: 'Users', href: '/admin/users' },
         { title: 'Categories', href: '/admin/categories' },
         { title: 'Comments', href: '/admin/comments' },
         { title: 'Threads', href: '/admin/threads' },
       ]
    }
   },
  computed: {
    currrentPath(){
      return this.$page.url;
    }
  }
 }
</script>

<style>
</style>