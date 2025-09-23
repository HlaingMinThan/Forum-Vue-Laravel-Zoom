<template>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ isEdit ? "Edit user" : "Create user" }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{
                        isEdit
                            ? "Update the fields below."
                            : "Fill in the details to create a new user."
                    }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl border shadow-sm">
            <div class="px-6 py-4 border-b bg-gray-50 rounded-t-xl">
                <div class="font-medium text-gray-900">User details</div>
            </div>

            <form @submit.prevent="submit" class="p-6 space-y-6">
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        id="name"
                        type="text"
                        v-model.trim="name"
                        placeholder="e.g. Jane Doe"
                        class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        :aria-invalid="Boolean(errors.name)"
                        :aria-describedby="
                            errors.name ? 'name-error' : undefined
                        "
                    />
                    <p
                        v-if="errors.name"
                        id="name-error"
                        class="mt-2 text-sm text-red-600"
                    >
                        {{ errors.name }}
                    </p>
                </div>

                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        id="email"
                        type="email"
                        v-model.trim="email"
                        placeholder="jane@example.com"
                        class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        :aria-invalid="Boolean(errors.email)"
                        :aria-describedby="
                            errors.email ? 'email-error' : undefined
                        "
                    />
                    <p
                        v-if="errors.email"
                        id="email-error"
                        class="mt-2 text-sm text-red-600"
                    >
                        {{ errors.email }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center justify-between">
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                                >Password</label
                            >
                            <span class="text-xs text-gray-500">{{
                                isEdit ? "Optional" : "Required"
                            }}</span>
                        </div>
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            v-model="password"
                            placeholder="••••••••"
                            class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            :aria-invalid="Boolean(errors.password)"
                            :aria-describedby="
                                errors.password ? 'password-error' : undefined
                            "
                        />
                        <p
                            v-if="errors.password"
                            id="password-error"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ errors.password }}
                        </p>
                    </div>
                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700"
                            >Confirm password</label
                        >
                        <input
                            id="password_confirmation"
                            :type="showPassword ? 'text' : 'password'"
                            v-model="passwordConfirmation"
                            placeholder="••••••••"
                            class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            :aria-invalid="
                                Boolean(errors.password_confirmation)
                            "
                            :aria-describedby="
                                errors.password_confirmation
                                    ? 'password_confirmation-error'
                                    : undefined
                            "
                        />
                        <p
                            v-if="errors.password_confirmation"
                            id="password_confirmation-error"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ errors.password_confirmation }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input
                        id="show_password"
                        type="checkbox"
                        v-model="showPassword"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <label for="show_password" class="text-sm text-gray-700"
                        >Show password</label
                    >
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t">
                    <Link
                        href="/admin"
                        class="px-4 py-2 rounded-xl border text-gray-700 hover:bg-gray-50"
                        >Cancel</Link
                    >
                    <button
                        type="submit"
                        :disabled="processing"
                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{
                            processing
                                ? isEdit
                                    ? "Saving..."
                                    : "Creating..."
                                : isEdit
                                ? "Save changes"
                                : "Create"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    components: { Link },
    props: {
        user: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            name: this.user?.name ?? "",
            email: this.user?.email ?? "",
            password: "",
            passwordConfirmation: "",
            showPassword: false,
            processing: false,
        };
    },
    computed: {
        isEdit() {
            return Boolean(this.user && this.user.id);
        },
        errors() {
            return this.$page?.props?.errors ?? {};
        },
    },
    methods: {
        async submit() {
            if (this.processing) return;
            this.processing = true;
            try {
                // Backend store/update routes are not defined yet.
                // Left intentionally as a no-op to focus on design.
            } finally {
                this.processing = false;
            }
        },
    },
};
</script>

<style></style>
