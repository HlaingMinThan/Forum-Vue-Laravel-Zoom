<script setup>
import { ref, onMounted ,computed, watch, onBeforeUnmount } from 'vue';
import axios from 'axios';
import { Link, usePage, usePoll, router } from '@inertiajs/vue3';

// for load noti data 180000ms (3min)
usePoll(180000, {
    only: ['notifications','unread_count']
})

const open = ref(false);
const containerRef = ref(null);

const page = usePage();

// load notification in start
const items = ref(Array.isArray(page.props.notifications) ? [...page.props.notifications] : []);
const unreadCount = ref(Number(page.props.unread_count || 0));
const loading = ref(false);
const hasMore = ref(true);
let currentPage = 1;

watch(() => page.props.notifications, (val) => {
    if (Array.isArray(val)) {
        items.value = [...val];
        // reset paging when server props refresh
        currentPage = 1;
        hasMore.value = true;
    }
});

watch(() => page.props.unread_count, (val) => {
    unreadCount.value = Number(val || 0);
});

function toggleDropdown() {
    open.value = !open.value;
}

// for comment detalil
const threadCommentUrl = (threadId, commentId) => {
  return route('threads.show', threadId) + (commentId ? `#comment-${commentId}` : '');
};

function handleClickOutside(e) {
    if (!open.value) return;
    const el = containerRef.value;
    if (el && !el.contains(e.target)) {
        open.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside, true);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside, true);
});

async function fetchMore() {
    if (!hasMore.value || loading.value) return;
    loading.value = true;
    try {
        const res = await axios.get(route('notifications.index'), { params: { page: currentPage + 1, perPage: 5 } });
        const { data, has_more, unread_count } = res.data;
        if (Array.isArray(data) && data.length) {
            items.value = items.value.concat(data);
            currentPage += 1;
            hasMore.value = !!has_more;
        } else {
            hasMore.value = false;
        }
        if (typeof unread_count !== 'undefined') {
            unreadCount.value = Number(unread_count || 0);
        }
    } finally {
        loading.value = false;
    }
}

async function markAllRead() {
    try {
        await axios.post(route('notifications.read_all'));
        items.value = items.value.map(n => ({ ...n, read_at: n.read_at || new Date().toISOString() }));
        unreadCount.value = 0;
    } catch (e) {}
}

async function markRead(id) {
    try {
        await axios.post(route('notifications.read', id));
        let decremented = false;
        items.value = items.value.map(n => {
            if (n.id === id) {
                if (!n.read_at) {
                    decremented = true;
                }
                return { ...n, read_at: n.read_at || new Date().toISOString() };
            }
            return n;
        });
        if (decremented && unreadCount.value > 0) unreadCount.value -= 1;
    } catch (e) {}
}

function truncate(text, length = 70) {
    if (!text) return '';
    return text.length > length ? text.slice(0, length - 1) + '…' : text;
}

function stripMarkdown(s = '') {
    return s
        .replace(/!\[[^\]]*\]\([^)]*\)/g, '') // images ![alt](url)
        .replace(/\[[^\]]*\]\([^)]*\)/g, '$1') // links [text](url)
        .replace(/(^|\s)([*_~`>#-]{1,3})+/g, '$1') // common md symbols
        .replace(/```[\s\S]*?```/g, '') // code blocks
        .replace(/`[^`]*`/g, '') // inline code
        .replace(/\s+/g, ' ') // collapse spaces
        .trim();
}


async function openAndMark(n) {
    await markRead(n.id);
    open.value = false;
    const href = threadCommentUrl(n.thread_id, n.type === 'comment' ? n.comment_id : null);
    router.visit(href);
}
</script>

<template>
    <div class="relative me-1" ref="containerRef">
        <!-- Bell Button -->
        <button @click="toggleDropdown" class="relative">

            <svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                <path style="fill:#FFAA00;" d="M256,100.174c-27.619,0-50.087-22.468-50.087-50.087S228.381,0,256,0s50.087,22.468,50.087,50.087
	S283.619,100.174,256,100.174z M256,33.391c-9.196,0-16.696,7.5-16.696,16.696s7.5,16.696,16.696,16.696
	c9.196,0,16.696-7.5,16.696-16.696S265.196,33.391,256,33.391z" />
                <path style="fill:#F28D00;" d="M256.006,0v33.394c9.194,0.003,16.69,7.5,16.69,16.693s-7.496,16.69-16.69,16.693v33.394
	c27.618-0.004,50.081-22.469,50.081-50.087S283.624,0.004,256.006,0z" />
                <path style="fill:#FFAA00;" d="M256,512c-46.043,0-83.478-37.435-83.478-83.478c0-9.228,7.467-16.696,16.696-16.696h133.565
	c9.228,0,16.696,7.467,16.696,16.696C339.478,474.565,302.043,512,256,512z" />
                <path style="fill:#F28D00;" d="M322.783,411.826h-66.777V512c46.042-0.004,83.473-37.437,83.473-83.478
	C339.478,419.293,332.011,411.826,322.783,411.826z" />
                <path style="fill:#FFDA44;" d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783
	C154.565,66.793,72.358,149,72.348,250.435v97.678c-19.41,6.901-33.384,25.233-33.391,47.017
	c0.01,27.668,22.419,50.075,50.087,50.085h333.913c27.668-0.01,50.077-22.417,50.087-50.085
	C473.036,373.346,459.063,355.014,439.652,348.113z" />
                <path style="fill:#FFAA00;" d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783v378.432h166.957
	c27.668-0.01,50.077-22.417,50.087-50.085C473.036,373.346,459.063,355.014,439.652,348.113z" />
                <path style="fill:#FFF3DB;" d="M155.826,267.13c-9.228,0-16.696-7.467-16.696-16.696c0-47.022,28.011-89.283,71.381-107.641
	c8.446-3.587,18.294,0.326,21.88,8.836c3.62,8.51-0.358,18.294-8.836,21.88c-31.012,13.142-51.033,43.337-51.033,76.925
	C172.522,259.663,165.054,267.13,155.826,267.13z" />
            </svg>
            <span v-if="unreadCount"
                class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1">
                {{ unreadCount }}
            </span>
        </button>

        <!-- Dropdown -->
        <div v-if="open" class="absolute right-0 mt-2 w-80 bg-white shadow-xl rounded-xl overflow-hidden z-50">
            <div class="flex items-center justify-between px-3 py-2 border-b bg-gray-50" >
                <span class="text-sm font-semibold text-gray-700">Notifications</span>
                <button @click.stop="markAllRead" class="text-xs text-blue-600 hover:underline" v-if="items.length">Mark all read</button>
            </div>
            <div class="max-h-80 overflow-y-auto">
                <ul>
                    <li v-if="!items.length" class="p-4 text-gray-500 text-sm text-center">
                        No new notifications
                    </li>
                <li v-for="n in items" :key="n.id" class="p-3 hover:bg-gray-50 border-b">
                    <div class="flex gap-3 items-start">
                        <Link as="button" type="button" @click="openAndMark(n)" class="flex gap-3 flex-1 min-w-0 text-left">
                            <div class="mt-1">
                                <span v-if="n.type === 'comment'" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">💬</span>
                                <span v-else-if="n.type === 'like'" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-rose-100 text-rose-600">❤</span>
                                <span v-else class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-600">🔔</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ truncate(n.thread_title, 30) }}</p>
                                <p v-if="n.type === 'comment'" class="text-xs text-gray-700 mt-0.5">
                                    <span class="font-medium">{{ n.comment_user }}</span> commented: <span class="text-gray-600">{{ truncate(stripMarkdown(n.comment_body), 50) }}</span>
                                </p>
                                <p v-else-if="n.type === 'like'" class="text-xs text-gray-700 mt-0.5">
                                    <span class="font-medium">{{ n.liked_user }}</span> liked your thread
                                </p>
                                <p class="text-[11px] text-gray-400 mt-1">{{ n.created_at }}</p>
                            </div>
                        </Link>
                        <button @click.stop.prevent="markRead(n.id)" :title="n.read_at ? 'Read' : 'Mark as read'" class="mt-1 text-xs">
                            <span v-if="!n.read_at" class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                            <span v-else class="inline-block h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                        </button>
                    </div>
                </li>
                </ul>
            </div>
            <div class="p-2 text-center" v-if="items.length">
                <button @click.stop="fetchMore" class="text-sm text-blue-600 hover:underline disabled:text-gray-400" :disabled="!hasMore || loading">
                    <span v-if="loading">Loading…</span>
                    <span v-else-if="hasMore">See more</span>
                    <span v-else>No more</span>
                </button>
            </div>
        </div>
    </div>
</template>
