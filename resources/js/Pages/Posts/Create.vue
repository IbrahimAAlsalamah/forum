<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(["topics", "words"]);

const form = useForm({
    title: "",
    topic_id: props.topics[0].id,
    body: "",
});

const createPost = () => form.post(route("posts.store"));
</script>
<template>
    <AppLayout title="Create a Post">
        <Container>
            <PageHeading>{{ words.create }}</PageHeading>

            <form @submit.prevent="createPost" class="mt-4">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput
                        id="title"
                        class="w-full"
                        v-model="form.title"
                        :placeholder="words.title"
                    />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="topic_id">{{ words.topic }}</InputLabel>
                    <select
                        id="topic_id"
                        v-model="form.topic_id"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-2"
                    >
                        <option
                            v-for="topic in topics"
                            :key="topic.id"
                            :value="topic.id"
                        >
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-2" />
                </div>

                <div class="mt-2">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <TextAreaInput id="body" v-model="form.body" rows="20" />
                    <InputError :message="form.errors.body" class="mt-2" />
                </div>
                <div class="mt-2">
                    <PrimaryButton type="submit"
                        >{{ words.create }}
                    </PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>
