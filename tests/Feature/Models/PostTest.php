<?php

use App\Models\Post;
use Illuminate\Support\Str;

it('uses title case for titles', function () {
    $post = Post::factory()->create(['title' => 'Hi there !']);

    expect($post->title)->toBe('Hi There !');
});

it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', ['post' => $post, 'slug' => Str::slug($post->title)]));
});

it('can generate additional query parameters to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', ['post' => $post, 'slug' => Str::slug($post->title), 'page' => 2]));
});
