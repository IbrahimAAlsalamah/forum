<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { relativeDate } from "@/Utilities/date";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PostList from "@/Components/PostList.vue";
import { onMounted, ref, watch } from "vue";
import { useInfiniteScroll } from "@/Composables/useInfiniteScroll";

const props = defineProps([
    "posts",
    "selectedTopic",
    "topics",
    "query",
    "words",
]);

const searchForm = useForm({
    query: props.query,
    page: 1,
});

const page = usePage();
const search = () => searchForm.get(page.url);

const landmark = ref(null);
const { items } = useInfiniteScroll("posts", landmark);
</script>

<template>
    <AppLayout>
        <Container>
            <div>
                <PageHeading
                    v-text="selectedTopic ? selectedTopic.name : words.all"
                />
                <p v-if="selectedTopic" class="text-lg text-gray-400">
                    {{ selectedTopic.description }}
                </p>
            </div>

            <menu
                class="flex flex-wrap space-x-2 mt-8 mb-4 rtl:space-x-reverse"
            >
                <li>
                    <Pill
                        :href="
                            route('posts.index', { query: searchForm.query })
                        "
                        :filled="!selectedTopic"
                        >{{ words.all }}
                    </Pill>
                </li>

                <li v-for="topic in topics" :key="topic.id">
                    <Pill
                        :href="
                            route('posts.index', {
                                topic: topic.slug,
                                query: searchForm.query,
                            })
                        "
                        :filled="topic.id === selectedTopic?.id"
                    >
                        {{ topic.name }}
                    </Pill>
                </li>
            </menu>

            <form @submit.prevent="search">
                <div>
                    <InputLabel for="query">{{ words.search }}</InputLabel>
                    <div class="flex space-x-2 mt-1">
                        <TextInput
                            v-model="searchForm.query"
                            id="query"
                            class="w-full"
                        />
                        <SecondaryButton type="submit">
                            {{ words.search }}
                        </SecondaryButton>
                    </div>
                </div>
            </form>

            <PostList :posts="items" />

            <!--            <Pagination :meta="posts.meta" />-->

            <!--            <Link @click.prevent="loadMoreItems">Load More</Link>-->

            <div ref="landmark"></div>
        </Container>
    </AppLayout>
</template>
