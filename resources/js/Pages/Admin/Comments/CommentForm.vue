<template>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Edit Comment
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Update the fields below.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl border shadow-sm">
            <div class="px-6 py-4 border-b bg-gray-50 rounded-t-xl">
                <div class="font-medium text-gray-900">Comment details</div>
            </div>

            <form @submit.prevent="submit" class="p-6 space-y-6">
                <div>
                    <label
                        for="content"
                        class="block text-sm font-medium text-gray-700"
                        >Content</label
                    >
                    <VMdEditor v-model="content" height="200px" />
                    <div class="mt-2 text-xs text-gray-500">
                        {{ charCount }}/1000
                    </div>
                    <p v-if="errors.body" class="mt-2 text-sm text-red-600">
                        {{ errors.body }}
                    </p>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t">
                    <Link
                        :href="route('comments.index')"
                        class="px-4 py-2 rounded-xl border text-gray-700 hover:bg-gray-50"
                        >Cancel</Link
                    >
                    <button
                        type="submit"
                        :disabled="processing || !content.trim()"
                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ processing ? "Saving..." : "Save changes" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import VMdEditor from "@kangc/v-md-editor";
import "@kangc/v-md-editor/lib/style/base-editor.css";
import githubTheme from "@kangc/v-md-editor/lib/theme/github.js";
import "@kangc/v-md-editor/lib/theme/style/github.css";
VMdEditor.use(githubTheme);

export default {
    components: { Link, VMdEditor },
    props: {
        comment: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            content: this.comment?.content ?? "",
            processing: false,
        };
    },
    computed: {
        errors() {
            return this.$page?.props?.errors ?? {};
        },
        charCount() {
            return this.content.length;
        },
    },
    methods: {
        async submit() {
            if (this.processing) return;
            this.processing = true;
            const method = "put";
            const url = route("comments.update", this.comment.id);
            try {
                await this.$inertia[method](
                    url,
                    {
                        body: this.content,
                    },
                    { preserveScroll: true }
                );
            } finally {
                this.processing = false;
            }
        },
    },
};
</script>

<style></style>
