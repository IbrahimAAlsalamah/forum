<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import PostList from "@/Components/PostList.vue";
import CommentList from "@/Components/CommentList.vue";
import LikeList from "@/Components/LikeList.vue";
import { ref } from "vue";
import { useInfiniteScroll } from "@/Composables/useInfiniteScroll.js";

const props = defineProps(["posts", "comments", "likes", "section", "words"]);

// const landmark = ref(null);
// const { items } = useInfiniteScroll(
//     props.section ? props.section : "posts",
//     landmark,
// );
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-pink-100 flex p-8">
            <div
                class="bg-pink-200 w-32 h-32 rounded-md text-pink-300 flex justify-center items-center text-4xl font-bold"
            >
                IS
            </div>
        </div>
        <div class="px-8 py-2 bg-white">
            <div class="py-4 bg-white space-y-1">
                <h3 class="font-bold text-pink-950 text-lg">
                    Ibrahim Alsalamah
                </h3>
                <p class="text-pink-950/40 font-bold text-sm">
                    Hey, I’m Ibrahim — a passionate developer who loves turning
                    ideas into real, functional, and clean web experiences. I
                    enjoy working with modern tools like Laravel, Vue.
                </p>
            </div>
            <ul
                class="grid grid-cols-3 py-4 px-2 justify-items-center bg-white text-center"
            >
                <li class="border-r w-full">
                    <NavLink
                        :href="route('profileprofile.index')"
                        :active="!section"
                        >{{ words.posts }}
                    </NavLink>
                </li>
                <li class="border-r w-full">
                    <NavLink
                        :href="
                            route('profileprofile.index', {
                                section: 'comments',
                            })
                        "
                        :active="section === 'comments'"
                        >{{ words.comments }}
                    </NavLink>
                </li>
                <li>
                    <NavLink
                        :href="
                            route('profileprofile.index', { section: 'likes' })
                        "
                        :active="section === 'likes'"
                        >{{ words.likes }}
                    </NavLink>
                </li>
            </ul>
            <CommentList v-if="section === 'comments'" :comments="comments" />
            <LikeList v-else-if="section === 'likes'" :likes="likes.data" />
            <PostList v-if="!section" :posts="posts.data" />

            <!--            <div ref="landmark"></div>-->
        </div>
    </AppLayout>
</template>
