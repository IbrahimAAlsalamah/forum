<script setup>
import {relativeDate} from "@/Utilities/date.js";
import {Link, router, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import {HandThumbDownIcon, HandThumbUpIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps(['comment'])

const emit = defineEmits(['edit', 'delete']);

</script>

<template>
    <div class="sm:flex items-center">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="comment.user.profile_photo_url" class="h-10 w-10 rounded-full" />
        </div>
        <div>
            <div class="text-indigo-800 font-semibold">{{ comment.user.name }}</div>
        </div>
    </div>
    <div>
        <div class="pl-14 break-all">{{ comment.body }}</div>
        <div class="flex justify-between mt-2">
            <div class="mt-1 space-x-3 pl-14 flex items-center">

                <span class="text-pink-600 font-bold text-sm">{{ comment.likes_count }} likes</span>
                <div v-if="$page.props.auth.user" class="flex items-center ">
                    <Link v-if="comment.can.like" preserve-scroll :href="route('likes.store', ['comment', comment.id])" method="post">
                        <HandThumbUpIcon class="size-4 text-pink-600" />
                    </Link>
                    <Link v-else preserve-scroll :href="route('likes.destroy', ['comment', comment.id])" method="delete">
                        <HandThumbDownIcon class="size-4 text-pink-600" />
                    </Link>
                </div>
                <span class="text-[12px] text-gray-500 font-light">{{ relativeDate(comment.created_at) }} ago</span>
            </div>
            <div class="flex space-x-4">
                <form v-if="comment.can?.delete" @submit.prevent="emit('delete', comment.id)">
                    <button class="text-red-600 text-sm">Delete</button>
                </form>
                <form v-if="comment.can?.update" @submit.prevent="emit('edit', comment.id)">
                    <button class="text-indigo-900 text-sm">Edit</button>
                </form>
            </div>
        </div>
    </div>

</template>
