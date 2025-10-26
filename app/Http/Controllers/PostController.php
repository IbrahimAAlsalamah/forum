<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ?Topic $topic = null)
    {

        $posts = Post::with(['user', 'topic'])
            ->when($topic, fn (Builder $query) => $query->whereBelongsTo($topic))
            ->when(
                $request->query('query'),
                fn (Builder $query) => $query->whereAny(['title', 'body'], 'like', '%'.$request->query('query').'%'))
            ->latest()
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $words = [
            'all' => __('All Posts'),
            'search' => __('Search'),
        ];

        return inertia('Posts/Index', [
            'posts' => PostResource::collection($posts),
            'topics' => fn () => TopicResource::collection(Topic::all()),
            'selectedTopic' => fn () => $topic ? TopicResource::make($topic) : null,
            'query' => $request->query('query'),
            'words' => $words,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Posts/Create', [
            'topics' => fn () => TopicResource::collection(Topic::all()),
            'words' => [
                'create' => __('Create Post'),
                'topic' => __('Select a Topic'),
                'title' => __('title'),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120', 'min:10'],
            'topic_id' => ['required', 'exists:topics,id'],
            'body' => ['required', 'string', 'max:10000', 'min:100'],
        ]);

        $post = Auth::user()->posts()->create($data);

        return redirect($post->showRoute());
    }

    /**
     * Display the specified resource.≤
     */
    public function show(Request $request, Post $post)
    {

        if (! Str::contains($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), status: 301);
        }

        $t = [
            'edit' => __('Edit'),
            'comments' => __('Comments'),
            'addComment' => __('Add Comment'),
            'likes' => __('Likes'),
        ];

        $post->load('user', 'topic');

        return inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post)->withLikePermission(),
            'comments' => function () use ($post) {

                $commentResource = CommentResource::collection($post->comments()->with('user')->latest()->latest('id')->paginate(10));
                $commentResource->collection->transform(fn ($comment) => $comment->withLikePermission());

                return $commentResource;
            },
            'words' => $t,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('posts.index');
    }
}
