<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ thread ? "Edit" : "Create New" }} Thread
                        </h1>
                        <p class="mt-2 text-gray-600">
                            Share your thoughts and start a discussion
                        </p>
                    </div>
                    <Link
                        :href="backUrl"
                        class="flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        <span>Back</span>
                    </Link>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <form @submit.prevent="submitForm" class="p-8">
                    <!-- Title Field -->
                    <div class="mb-6">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Thread Title *
                        </label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            placeholder="Enter a descriptive title for your thread..."
                        />
                        <p
                            v-if="errors?.title"
                            class="text-xs mt-2 ml-1 text-red-500"
                        >
                            {{ errors.title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Make it clear and specific to help others find your
                            thread
                        </p>
                    </div>

                    <!-- Category Selection -->
                    <div class="mb-6">
                        <label
                            for="category"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Category *
                        </label>
                        <select
                            id="category"
                            v-model="form.category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        >
                            <option value="">Select a category</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                                class="py-2"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <p
                            v-if="errors?.category_id"
                            class="text-xs mt-2 ml-1 text-red-500"
                        >
                            {{ errors.category_id }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Choose the most appropriate category for your thread
                        </p>
                    </div>

                    <!-- Tags Selection -->
                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Tags
                        </label>
                        <div class="space-y-3">
                            <!-- Selected Tags -->
                            <div
                                v-if="selectedTags?.length > 0"
                                class="flex flex-wrap gap-2"
                            >
                                <span
                                    v-for="tag in selectedTags"
                                    :key="tag.id"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                                >
                                    #{{ tag.name }}
                                    <button
                                        @click="removeTag(tag)"
                                        type="button"
                                        class="ml-2 text-blue-600 hover:text-blue-800"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </div>

                            <!-- Tag Selection -->
                            <div class="relative">
                                <input
                                    v-model="tagSearch"
                                    type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Search and add tags..."
                                    @input="filterTags"
                                />

                                <!-- Tag Suggestions Dropdown -->
                                <div
                                    v-if="filteredTags.length > 0 && tagSearch"
                                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto"
                                >
                                    <div
                                        v-for="tag in filteredTags"
                                        :key="tag.id"
                                        @click="addTag(tag)"
                                        class="px-4 py-2 hover:bg-gray-50 cursor-pointer flex items-center space-x-2"
                                    >
                                        <span class="text-blue-600">#</span>
                                        <span>{{ tag.name }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Popular Tags -->
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 mb-2">
                                    Popular tags:
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-for="tag in popularTags"
                                        :key="tag.id"
                                        @click="addTag(tag)"
                                        type="button"
                                        class="px-3 py-1 text-sm border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        :class="{
                                            'bg-blue-50 border-blue-300 text-blue-700':
                                                isTagSelected(tag),
                                        }"
                                    >
                                        #{{ tag.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Field -->
                    <div class="mb-6">
                        <label
                            for="body"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Thread Content *
                        </label>
                        <v-md-editor
                            v-model="form.body"
                            height="400px"
                        ></v-md-editor>
                        <p
                            v-if="errors?.body"
                            class="text-xs mt-2 ml-1 text-red-500"
                        >
                            {{ errors.body }}
                        </p>
                        <div
                            class="mt-2 flex items-center justify-between text-sm text-gray-500"
                        >
                            <span
                                >Be clear and detailed to get better
                                responses</span
                            >
                            <span>{{ form.body?.length }}/5000 characters</span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex items-center justify-end pt-6 border-t border-gray-200"
                    >
                        <div class="flex items-center space-x-4">
                            <button
                                type="button"
                                @click="$router.back()"
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                <span v-if="form.processing">Creating...</span>
                                <span v-else
                                    >{{
                                        thread ? "Update" : "Create"
                                    }}
                                    Thread</span
                                >
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preview Modal -->
            <div
                v-if="showPreview"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            >
                <div
                    class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto"
                >
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Thread Preview
                            </h3>
                            <button
                                @click="showPreview = false"
                                class="text-gray-400 hover:text-gray-600"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4">
                            {{ form.title }}
                        </h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span
                                class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                            >
                                {{ getCategoryName(form.category_id) }}
                            </span>
                            <div
                                v-if="selectedTags.length > 0"
                                class="flex space-x-2"
                            >
                                <span
                                    v-for="tag in selectedTags"
                                    :key="tag.id"
                                    class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full"
                                >
                                    #{{ tag.name }}
                                </span>
                            </div>
                        </div>
                        <div class="prose max-w-none">
                            <p class="whitespace-pre-wrap">{{ form.body }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link, useForm } from "@inertiajs/vue3";

export default {
    name: "NewThread",
    components: { Link },
    props: {
        thread: {
            type: Object,
            default: () => null,
        },
        categories: {
            type: Array,
            default: () => [],
        },
        tags: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            form: useForm({
                title: this.thread?.title,
                body: this.thread?.body,
                category_id: this.thread?.category_id,
                tag_ids: [],
                redirect_to: window.location.pathname.startsWith("/admin")
                    ? "/admin"
                    : "/",
            }),
            selectedTags: this.thread?.tags ?? [],
            tagSearch: "",
            filteredTags: [],
            showPreview: false,
        };
    },
    computed: {
        popularTags() {
            return this.tags.slice(0, 6); // Show first 6 tags as popular
        },
        errors() {
            return this.$page.props.errors;
        },
        backUrl() {
            return window.location.pathname.startsWith("/admin")
                ? "/admin"
                : "/";
        },
    },
    methods: {
        submitForm() {
            this.form.tag_ids = this.selectedTags.map((tag) => tag.id);
            if (!!this.thread) {
                this.form.put(route("threads.update", this.thread.id));
            } else {
                this.form.post("/threads");
            }
        },
        addTag(tag) {
            if (!this.isTagSelected(tag)) {
                this.selectedTags?.push(tag);
            }
            this.tagSearch = "";
            this.filteredTags = [];
        },
        removeTag(tag) {
            this.selectedTags = this.selectedTags?.filter(
                (t) => t.id !== tag.id
            );
        },
        isTagSelected(tag) {
            return this.selectedTags?.some((t) => t.id === tag.id);
        },
        filterTags() {
            if (!this.tagSearch) {
                this.filteredTags = [];
                return;
            }

            this.filteredTags = this.tags.filter(
                (tag) =>
                    tag.name
                        .toLowerCase()
                        .includes(this.tagSearch.toLowerCase()) &&
                    !this.isTagSelected(tag)
            );
        },
        saveDraft() {
            // Implement draft saving functionality
            console.log("Saving draft...");
        },
        previewThread() {
            this.showPreview = true;
        },
        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },
    },
};
</script>

<style scoped>
.prose {
    line-height: 1.6;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
