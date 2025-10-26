<script setup>
import Pill from "@/Components/Pill.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { relativeDate } from "@/Utilities/date.js";
import { useConfirm } from "@/Utilities/Composables/useConfirm.js";

defineProps(["post"]);
const { confirmation } = useConfirm();

const formattedDate = (post) => relativeDate(post.created_at);

const deletePost = async (post_id) => {
    if (!(await confirmation("Are you sure you want to delete it ?"))) {
        return;
    }

    router.delete(route("posts.destroy", { post: post_id }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Link :href="post.routes.show" class="group block px-2 py-4">
        <span class="font-bold text-lg group-hover:text-indigo-500">{{
            post.title
        }}</span>
    </Link>
    <Pill :href="route('posts.index', { topic: post.topic.slug })">
        {{ post.topic.name }}
    </Pill>
    <div class="flex space-x-3 mt-3 items-center rtl:space-x-reverse">
        <form
            v-if="$page.props.auth.user.is_admin"
            @submit.prevent="deletePost(post.id)"
        >
            <button class="text-red-600 text-sm">
                {{ usePage().props.t.delete }}
            </button>
        </form>
        <span class="block text-gray-500 text-sm"
            >{{ formattedDate(post) }} ago</span
        >
    </div>
</template>
