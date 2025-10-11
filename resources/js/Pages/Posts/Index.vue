<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import { relativeDate } from "@/Utilities/date";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";


    const props = defineProps(['posts', 'selectedTopic', 'topics', 'query']);

    const formattedDate = (post) => relativeDate(post.created_at);

    const   searchForm = useForm({
        query: props.query,
        page: 1
    });

    const page = usePage();
    const search = () => searchForm.get(page.url);

</script>

<template>
    <AppLayout>
        <Container>

            <div>
                <PageHeading v-text="selectedTopic ? selectedTopic.name : 'All Posts'" />
                <p v-if="selectedTopic" class="text-lg text-gray-400">{{ selectedTopic.description }}</p>
            </div>

            <menu class="flex space-x-2 mt-8 mb-4">
                <li><Pill :href="route('posts.index', {query: searchForm.query})" :filled="! selectedTopic">All Posts</Pill></li>

                <li v-for="topic in topics" :key="topic.id">

                    <Pill
                        :href="route('posts.index', {topic: topic.slug, query: searchForm.query})"
                        :filled="topic.id === selectedTopic?.id"
                    >
                        {{ topic.name }}
                    </Pill>

                </li>
            </menu>

            <form @submit.prevent="search">
                <div>
                    <InputLabel for="query">Search</InputLabel>
                    <div class="flex space-x-2 mt-1">
                        <TextInput v-model="searchForm.query"  id="query" class="w-full" />
                        <SecondaryButton type="submit">Search</SecondaryButton>
                    </div>
                </div>
            </form>

            <ul class="divide-y">
                <li v-for="post in posts.data" :key="post.id" class="mt-3">
                    <Link :href="post.routes.show" class="group block px-2 py-4">
                        <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="block mt-1 text-gray-500">{{ formattedDate(post) }} ago by {{ post.user.name }}</span>
                    </Link>
                    <Pill :href="route('posts.index', {topic: post.topic.slug})">
                        {{ post.topic.name }}
                    </Pill>
                </li>
            </ul>
            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>
