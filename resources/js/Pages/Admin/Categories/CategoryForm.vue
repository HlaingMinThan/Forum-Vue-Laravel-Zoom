<template>
  <div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">{{ isEdit ? 'Edit category' : 'Create category' }}</h1>
        <p class="mt-1 text-sm text-gray-500">{{ isEdit ? 'Update the fields below.' : 'Fill in the details to create a new category.' }}</p>
      </div>
      
    </div>

    <div class="bg-white rounded-xl border shadow-sm">
      <div class="px-6 py-4 border-b bg-gray-50 rounded-t-xl">
        <div class="font-medium text-gray-900">Category details</div>
      </div>

      <form @submit.prevent="submit" class="p-6 space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
            id="name"
            type="text"
            v-model.trim="name"
            placeholder="e.g. Announcements"
            class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            :aria-invalid="Boolean(errors.name)"
            :aria-describedby="errors.name ? 'name-error' : undefined"
          />
          <p v-if="errors.name" id="name-error" class="mt-2 text-sm text-red-600">{{ errors.name }}</p>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <span class="text-xs text-gray-500">Required</span>
          </div>
          <textarea
            id="description"
            v-model.trim="description"
            rows="5"
            placeholder="What belongs in this category?"
            class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            :aria-invalid="Boolean(errors.description)"
            :aria-describedby="errors.description ? 'description-error' : undefined"
          />
          <p v-if="errors.description" id="description-error" class="mt-2 text-sm text-red-600">{{ errors.description }}</p>
        </div>

        <div class="pt-2">
          <div class="text-sm text-gray-500">
            <span class="font-medium text-gray-700">Slug preview:</span>
            <span class="ml-2 inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5 text-xs font-medium">/{{ slugPreview }}</span>
          </div>
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t">
          <Link :href="route('categories.index')" class="px-4 py-2 rounded-xl border text-gray-700 hover:bg-gray-50">Cancel</Link>
          <button type="submit" :disabled="processing" class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50">
            {{ processing ? (isEdit ? 'Saving...' : 'Creating...') : (isEdit ? 'Save changes' : 'Create') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: { Link },
  props: {
    category: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      name: this.category?.name ?? '',
      description: this.category?.description ?? '',
      processing: false,
    };
  },
  computed: {
    isEdit() {
      return Boolean(this.category && this.category.id);
    },
    errors() {
      return this.$page?.props?.errors ?? {};
    },
    slugPreview() {
      const text = (this.name || '').toString().trim().toLowerCase();
      return text
        .normalize('NFD')
        .replace(/\p{Diacritic}/gu, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    },
  },
  methods: {
    async submit() {
      if (this.processing) return;
      this.processing = true;
      const method = this.isEdit ? 'put' : 'post';
      const url = this.isEdit
        ? route('categories.update', this.category.id)
        : route('categories.store');

      try {
        await this.$inertia[method](url, {
          name: this.name,
          description: this.description,
        }, { preserveScroll: true });
      } finally {
        this.processing = false;
      }
    },
  },
};
</script>

<style>

</style>