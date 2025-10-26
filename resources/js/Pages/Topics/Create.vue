<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import PageHeading from "@/Components/PageHeading.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps(["words"]);

const form = useForm({
    name: "",
    description: "",
});

const addTopic = () => {
    form.post(route("topics.store"));
};
</script>

<template>
    <AppLayout title="Create Topic">
        <Container>
            <PageHeading>{{ words.create }}</PageHeading>

            <form @submit.prevent="addTopic" class="mt-4">
                <div>
                    <InputLabel for="name" class="sr-only"
                        >{{ words.name }}
                    </InputLabel>
                    <TextInput
                        id="name"
                        class="w-full"
                        v-model="form.name"
                        :placeholder="words.name"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-2">
                    <InputLabel for="description" class="sr-only"
                        >{{ words.description }}
                    </InputLabel>
                    <TextAreaInput
                        id="description"
                        v-model="form.description"
                        rows="10"
                        :placeholder="words.description"
                    />
                    <InputError
                        :message="form.errors.description"
                        class="mt-2"
                    />
                </div>

                <div class="mt-2">
                    <PrimaryButton type="submit">{{
                        words.create
                    }}</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>
