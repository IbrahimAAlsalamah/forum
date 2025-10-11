<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;

use function Pest\Laravel\get;

it('can show a post', function () {
    $post = Post::factory()->create();

    get($post->showRoute())
        ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();

    $post->load('user', 'topic');

    get($post->showRoute())
        ->assertHasResource('post', PostResource::make($post)->withLikePermission());
});

it('can show a comments', function () {
    $this->withoutExceptionHandling();
    $post = Post::factory()->create();

    $comments = Comment::factory(2)->for($post)->create();

    $comments->load('user');

    $expectedResource = CommentResource::collection($comments->reverse());
    $expectedResource->collection->transform(fn (CommentResource $comment) => $comment->withLikePermission());

    get($post->showRoute())
        ->assertHasPaginatedResource('comments', $expectedResource);
});

it('will redirect if the slug is incorrect', function () {
    $post = Post::factory()->create(['title' => 'Hi there!']);

    get(route('posts.show', ['post' => $post, 'slug' => 'foo-bar']))
        ->assertRedirect($post->showRoute());

});
