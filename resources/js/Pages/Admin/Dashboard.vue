<template>
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="rounded-lg p-4 text-white bg-gradient-to-br from-indigo-500 to-indigo-600 shadow"
            >
                <div class="text-indigo-100 text-sm">Users</div>
                <div class="text-4xl font-extrabold">{{ stats.users }}</div>
            </div>
            <div
                class="rounded-lg p-4 text-white bg-gradient-to-br from-emerald-500 to-emerald-600 shadow"
            >
                <div class="text-emerald-100 text-sm">Threads</div>
                <div class="text-4xl font-extrabold">{{ stats.threads }}</div>
            </div>
            <div
                class="rounded-lg p-4 text-white bg-gradient-to-br from-amber-500 to-amber-600 shadow"
            >
                <div class="text-amber-100 text-sm">Categories</div>
                <div class="text-4xl font-extrabold">
                    {{ stats.categories }}
                </div>
            </div>
            <div
                class="rounded-lg p-4 text-white bg-gradient-to-br from-rose-500 to-rose-600 shadow"
            >
                <div class="text-rose-100 text-sm">Comments</div>
                <div class="text-4xl font-extrabold">{{ stats.comments }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="px-4 py-3 border-b font-medium">
                    Latest 10 Threads
                </div>
                <ul class="divide-y">
                    <li
                        v-for="thread in latestThreads"
                        :key="thread.id"
                        class="px-4 py-3"
                    >
                        <div class="font-medium">{{ thread.title }}</div>
                        <div class="text-xs text-gray-500">
                            by {{ thread.user?.name }} in
                            {{ thread.category?.name }} ·
                            {{ new Date(thread.created_at).toLocaleString() }}
                        </div>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-lg border shadow-sm">
                <div class="px-4 py-3 border-b font-medium">
                    Latest 10 Users
                </div>
                <ul class="divide-y">
                    <li
                        v-for="user in latestUsers"
                        :key="user.id"
                        class="px-4 py-3"
                    >
                        <div class="font-medium">{{ user.name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ user.email }} ·
                            {{ new Date(user.created_at).toLocaleString() }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        stats: { type: Object, required: true },
        latestThreads: { type: Array, required: true },
        latestUsers: { type: Array, required: true },
    },
};
</script>

<style></style>
