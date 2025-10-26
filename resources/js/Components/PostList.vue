<script setup>
import Pill from "@/Components/Pill.vue";
import { Link, router } from "@inertiajs/vue3";
import Post from "@/Components/Post.vue";

defineProps(["posts"]);
</script>

<template>
    <ul class="divide-y">
        <li v-for="post in posts" :key="post.id" class="mt-3">
            <Post :post="post" />
        </li>
    </ul>
</template>
