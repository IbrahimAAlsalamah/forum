<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function create()
    {
        $t = [
            'create' => __('Create Topic'),
            'name' => __('Name a Topic'),
            'description' => __('Description'),
        ];

        return inertia('Topics/Create', ['words' => $t]);
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'min:10'],
        ]);

        $topic = Topic::create([
            ...$attributes,
            'slug' => Str::lower($request['name']),
        ]);

        return to_route('posts.index', ['topic' => $topic->slug]);
    }
}
