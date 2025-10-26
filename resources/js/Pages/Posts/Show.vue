<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed, ref } from "vue";
import Container from "@/Components/Container.vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { relativeDate } from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModalWrapper from "@/Components/ConfirmationModalWrapper.vue";
import { useConfirm } from "@/Utilities/Composables/useConfirm.js";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";
import {
    HandThumbUpIcon,
    HandThumbDownIcon,
} from "@heroicons/vue/20/solid/index.js";
import { useInfiniteScroll } from "@/Composables/useInfiniteScroll.js";

const props = defineProps(["post", "comments", "words"]);

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    body: "",
});

const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);
const commentBeingEdit = computed(() =>
    props.comments.data.find(
        (comment) => comment.id === commentIdBeingEdited.value,
    ),
);

const { confirmation } = useConfirm();

const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdit.value?.body;
    commentTextAreaRef.value?.focus();
};

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
};

const addComment = () =>
    commentForm.post(route("posts.comments.store", props.post.id), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset(),
    });

const updateComment = async () => {
    if (!(await confirmation("Are you sure you want to Update it ?"))) {
        commentTextAreaRef.value?.focus();
        return;
    }

    commentForm.put(
        route("comments.update", {
            comment: commentIdBeingEdited.value,
            page: props.comments.meta.current_page,
        }),
        {
            onSuccess: cancelEditComment,
            preserveScroll: true,
        },
    );
};

const deleteComment = async (comment_id) => {
    if (!(await confirmation("Are you sure you want to delete it ?"))) {
        return;
    }

    router.delete(
        route("comments.destroy", {
            comment: comment_id,
            page: props.comments.meta.current_page,
        }),
        { preserveScroll: true },
    );
};

const landmark = ref(null);
const { items } = useInfiniteScroll("comments", landmark);
</script>

<template>
    <AppLayout :title="post.title">
        <Container>
            <Pill :href="route('posts.index', { topic: post.topic.slug })"
                >{{ post.topic.name }}
            </Pill>

            <PageHeading class="mt-2">{{ post.title }}</PageHeading>
            <div class="mt-1 space-x-3 flex items-center">
                <span class="text-pink-600 font-bold text-sm"
                    >{{ post.likes_count }} likes</span
                >
                <div v-if="$page.props.auth.user" class="flex items-center">
                    <Link
                        v-if="post.can.like"
                        :href="route('likes.store', ['post', post.id])"
                        method="post"
                    >
                        <HandThumbUpIcon class="size-4 text-pink-600" />
                    </Link>
                    <Link
                        v-else
                        :href="route('likes.destroy', ['post', post.id])"
                        method="delete"
                    >
                        <HandThumbDownIcon class="size-4 text-pink-600" />
                    </Link>
                </div>
                <span class="text-sm">|</span>
                <span class="text-gray-500 text-sm"
                    >{{ formattedDate }} ago by {{ post.user.name }}</span
                >
            </div>

            <article class="mt-4">
                <pre class="whitespace-pre-wrap font-sans break-all">{{
                    post.body
                }}</pre>
            </article>

            <div class="mt-6">
                <h2 class="font-semibold text-xl">{{ words.comments }}</h2>

                <form
                    v-if="$page.props.auth.user"
                    @submit.prevent="
                        () =>
                            commentIdBeingEdited
                                ? updateComment()
                                : addComment()
                    "
                >
                    <div>
                        <InputLabel for="body" class="sr-only"
                            >{{ words.comment }}
                        </InputLabel>
                        <TextAreaInput
                            ref="commentTextAreaRef"
                            id="body"
                            v-model="commentForm.body"
                            rows="4"
                            placeholder="add comment..."
                        />
                        <InputError :message="commentForm.errors.body" />
                    </div>

                    <PrimaryButton
                        type="submit"
                        class="mt-3"
                        :disabled="commentForm.processing"
                        v-text="
                            commentIdBeingEdited ? words.edit : words.addComment
                        "
                    >
                    </PrimaryButton>
                    <SecondaryButton
                        v-if="commentIdBeingEdited"
                        @click="cancelEditComment"
                        class="ml-2"
                    >
                        Cancel
                    </SecondaryButton>
                </form>

                <ul class="divide-y mt-2">
                    <li
                        v-for="comment in items"
                        :key="comment.id"
                        class="block px-2 pt-4 pb-1"
                    >
                        <Comment
                            @edit="editComment"
                            @delete="deleteComment(comment.id)"
                            :comment="comment"
                        />
                    </li>
                </ul>

                <!--                <Pagination :meta="comments.meta" :only="['comments']" />-->

                <div ref="landmark"></div>
            </div>
        </Container>
    </AppLayout>
</template>
