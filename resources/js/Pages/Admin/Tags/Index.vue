<template>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold tracking-tight">Tags</h1>
          <p class="text-sm text-gray-500">Manage forum Tags</p>
        </div>
        <button @click="openCreateModal"
          class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 transition-colors"
        >
          + New Tags
      </button>
      </div>

      <div
        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
      >
        <div
          class="px-4 py-3 border-b border-gray-200 flex items-center justify-between"
        >
          <div class="text-sm text-gray-600">{{ tags.length }} total</div>
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search tags..."
              class="w-60 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >
                  ID
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >
                  Name
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >
                  Slug
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              <tr
                v-for="tag in filteredTags"
                :key="tag.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ tag.id }}
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                >
                  {{ tag.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ tag.slug }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                  <div class="inline-flex items-center gap-2">
                    <button
                      @click="editTag(tag)"
                      class="px-3 py-1.5 rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200"
                    >
                      Edit
                    </button>
                    <button
                      @click="confirmDelete(tag)"
                      class="px-3 py-1.5 rounded-md text-red-700 bg-red-50 hover:bg-red-100 border border-red-200"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredTags.length === 0">
                <td
                  colspan="4"
                  class="px-6 py-10 text-center text-sm text-gray-500"
                >
                  No tags found.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- delete tag modal -->
      <div
        v-if="openDelete"
        class="fixed inset-0 -top-6 bg-black/50 flex items-center justify-center z-50"
      >
        <!-- Modal Content -->
        <div class="bg-white mb-36 rounded-lg w-96 p-6 shadow-lg relative">
          <h2 class="text-lg font-bold mb-4">Are you sure?</h2>
          <p class="text-gray-600 mb-6">
            This action cannot be undone. Do you want to delete this tag
            <strong>{{ deletingTag.name }}</strong>?
          </p>

          <!-- Buttons -->
          <div class="flex justify-end space-x-2">
            <button
              @click="openDelete = false"
              class="px-4 py-2 rounded border text-sm border-gray-300 hover:bg-gray-100"
            >
              Cancel
            </button>
            <button @click="tagDelete"
              class="px-4 py-2 rounded text-sm bg-red-600 hover:bg-red-700 text-white"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- create tag modal -->

      <div
        v-if="showForm"
        class="fixed inset-0 -top-6 bg-black/50 flex items-center justify-center z-50"
      >
        <!-- Modal Content -->
        <div class="bg-white mb-36 rounded-lg w-96 p-6 shadow-lg relative">
            <div class="flex items-center justify-between">
              <h1 class="text-lg font-bold text-blue-600 mb-3">
                {{ isEditing ? 'Edit Tag' : 'Create New Tag' }}
              </h1>
              <button @click="closeModal">
                  <svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z"/></svg>
              </button>
          </div>
          <form @submit.prevent="submitForm" class="flex flex-col gap-3">
            <label class="text-gray-600" for="">Tag Name :</label>
            <input
              v-model="form.name"
              type="text"
              class="py-1 border-0 border-b border-gray-500 focus:outline-none"
            />
            <p
              v-if="errors.name"
              class="mt-2 text-sm text-red-600 flex items-center"
            >
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              {{ errors.name }}
            </p>
            <button
              class="text-white py-1 self-end text-sm bg-blue-600 w-[100px] rounded-md"
              type="submit"
            >
              {{ isEditing ? 'Update' : '+ Create' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </template>

    <script>
  import { Link, useForm } from "@inertiajs/vue3";

  export default {
    props: {
      tags: {
        type: Array,
        default: () => [],
      },
    },
    components: { Link },
    data() {
      return {
        searchQuery: "",
        form: useForm({
          name: ''
        }),
        errors:{},
        showForm: false,
        editingTag: null,
        isEditing: false,

        openDelete : false,
        deletingTag : null,
      };
    },
    computed: {
      filteredTags() {
        const q = this.searchQuery.trim().toLowerCase();
        console.log(q);

        if (!q) return this.tags;
        return this.tags.filter((c) =>
          [String(c.id), c.name, c.slug].some((v) =>
            String(v).toLowerCase().includes(q)
          )
        );
      }
    },
    methods: {
      openCreateModal() {
        this.isEditing = false;
        this.editingTag = null;
        this.form.reset();
        this.errors = {};
        this.showForm = true;
      },

      editTag(tag) {
        this.isEditing = true;
        this.editingTag = tag;
        this.form.name = tag.name;
        this.errors = {};
        this.showForm = true;
      },

      closeModal() {
        this.showForm = false;
        this.isEditing = false;
        this.editingTag = null;
        this.form.reset();
        this.errors = {};
      },

      submitForm() {
        if (this.isEditing) {
          // Update
          this.form.put(route('tag.update', this.editingTag.id), {
              onError: (errors) => {
                  this.errors = errors
              },
            onSuccess: () => {
              this.closeModal();
            }
          });
        } else {
          // Create
          this.form.post(route('tag.store'), {
              onError: (errors) => {
                  this.errors = errors
              },
            onSuccess: () => {
              this.closeModal();
            }
          });
        }
      },
      confirmDelete(tag){
          this.openDelete = true
          this.deletingTag = tag
      },
      tagDelete(){
          this.$inertia.delete(this.route('tag.delete', this.deletingTag.id), {
          onSuccess: () => {
            this.openDelete = false
            this.deletingTag = null
          }
        })
      }

    }
  };
  </script>

    <style>
  </style>
