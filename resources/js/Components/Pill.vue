<template>
    <Link
        :href="href"
        class="py-1 text-sm font-bold rounded-full px-2 border border-indigo-800 text-indigo-800 hover:bg-indigo-800 hover:text-white"
        :class="{ ' bg-indigo-600 text-white ': filled }"
    >
        <slot></slot>
    </Link>
</template>
<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

defineProps({

    href: {
        required: true,
    },

    filled: {
        default: false,
    }
});
</script>
