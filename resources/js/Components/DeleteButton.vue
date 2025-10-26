<script setup>
defineProps(["submit"]);
</script>
<template>
    <form @submit.prevent="submit">
        <button class="text-red-600 text-sm">Delete</button>
    </form>
</template>

<!-- v-if="comment.can?.delete"-->
