<script setup>
import Comment from "@/Components/Comment.vue";
import Post from "@/Components/Post.vue";

defineProps(["likes"]);
</script>

<template>
    <ul class="divide-y space-y-4">
        <li v-for="like in likes" :key="like.id">
            <Comment v-if="like.type === 'comment'" :comment="like.likeable" />
            <Post v-else-if="like.type === 'post'" :post="like.likeable" />
        </li>
    </ul>
</template>
