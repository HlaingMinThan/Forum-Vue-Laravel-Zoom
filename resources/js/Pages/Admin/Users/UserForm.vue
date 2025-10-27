<template>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <!-- Page heading switches by create/edit mode -->
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
                <!-- Name -->
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

                <!-- Email -->
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

                <!-- Role select (maps to is_admin boolean) -->
                <div>
                    <label
                        for="role"
                        class="block text-sm font-medium text-gray-700"
                        >Role</label
                    >
                    <select
                        id="role"
                        v-model="isAdmin"
                        class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        :aria-invalid="Boolean(errors.is_admin)"
                        :aria-describedby="
                            errors.is_admin ? 'role-error' : undefined
                        "
                    >
                        <option :value="false">User</option>
                        <option :value="true">Admin</option>
                    </select>
                    <p
                        v-if="errors.is_admin"
                        id="role-error"
                        class="mt-2 text-sm text-red-600"
                    >
                        {{ errors.is_admin }}
                    </p>
                </div>

                <!-- Password + confirmation -->
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

                <!-- Show/hide password toggle -->
                <div class="flex items-center gap-2">
                    <input
                        id="show_password"
                        type="checkbox"
                        v-model="showPassword"
                        :true-value="true"
                        :false-value="false"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <label for="show_password" class="text-sm text-gray-700"
                        >Show password</label
                    >
                </div>

                <!-- Actions -->
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
        // When editing, the server injects the selected user as a prop
        user: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            // Form state
            name: this.user?.name ?? "",
            email: this.user?.email ?? "",
            isAdmin: Boolean(this.user?.is_admin ?? false),
            password: "",
            passwordConfirmation: "",
            showPassword: false,
            processing: false,
            // Local client-side validation errors (merged with server errors)
            localErrors: {},
        };
    },
    computed: {
        // Detect create vs edit mode
        isEdit() {
            return Boolean(this.user && this.user.id);
        },
        // Merge server-side validation errors with local client-side errors
        errors() {
            const serverErrors = this.$page?.props?.errors ?? {};
            return { ...serverErrors, ...this.localErrors };
        },
    },
    methods: {
        // Lightweight client-side validation mirroring server rules
        validateForm() {
            const errors = {};

            const trimmedName = (this.name || "").toString().trim();
            if (!trimmedName) {
                errors.name = "The name field is required.";
            } else if (trimmedName.length > 255) {
                errors.name =
                    "The name may not be greater than 255 characters.";
            }

            const trimmedEmail = (this.email || "").toString().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
            if (!trimmedEmail) {
                errors.email = "The email field is required.";
            } else if (!emailRegex.test(trimmedEmail)) {
                errors.email = "The email must be a valid email address.";
            } else if (trimmedEmail.length > 255) {
                errors.email =
                    "The email may not be greater than 255 characters.";
            }

            if (this.isAdmin !== true && this.isAdmin !== false) {
                errors.is_admin = "Please select a role.";
            }

            const hasPassword = (this.password || "").length > 0;
            if (!this.isEdit) {
                if (!hasPassword) {
                    errors.password = "The password field is required.";
                }
            }
            if (hasPassword && (this.password || "").length < 8) {
                errors.password = "The password must be at least 8 characters.";
            }
            if (
                (this.password || "").length > 0 ||
                (this.passwordConfirmation || "").length > 0
            ) {
                if (this.password !== this.passwordConfirmation) {
                    errors.password_confirmation =
                        "The password confirmation does not match.";
                }
            }

            this.localErrors = errors;
            return Object.keys(errors).length === 0;
        },
        // Submit to server (create or update) with Inertia
        async submit() {
            if (this.processing) return;
            this.processing = true;
            if (!this.validateForm()) {
                this.processing = false;
                return;
            }
            const method = this.isEdit ? "put" : "post";
            const url = this.isEdit
                ? route("users.update", this.user.id)
                : route("users.store");
            try {
                await this.$inertia[method](
                    url,
                    {
                        name: this.name,
                        email: this.email,
                        is_admin: this.isAdmin,
                        password: this.password,
                        password_confirmation: this.passwordConfirmation,
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
