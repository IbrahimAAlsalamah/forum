<script setup>
import Comment from "@/Components/Comment.vue";
import { router } from "@inertiajs/vue3";
import { useInfiniteScroll } from "@/Composables/useInfiniteScroll.js";
import { ref } from "vue";

const props = defineProps(["comments"]);

const deleteComment = async (comment_id) => {
    if (!(await confirmation("Are you sure you want to delete it ?"))) {
        return;
    }

    router.delete(
        route("comments.destroy", {
            comment: comment_id,
            page: props.comments.meta.current_page,
        }),
        { preserveScroll: true },
    );
};

const landmark = ref(null);
const { items } = useInfiniteScroll("comments", landmark);
</script>

<template>
    <ul class="divide-y mt-2">
        <li
            v-for="comment in items"
            :key="comment.id"
            class="block px-2 pt-4 pb-1"
        >
            <Comment @delete="deleteComment(comment.id)" :comment="comment" />
        </li>
    </ul>

    <div ref="landmark"></div>
</template>
