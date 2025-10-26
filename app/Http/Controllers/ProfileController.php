<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $likeables = $user->likes()->with('likeable')->paginate();

        $t = [
            'posts' => __('Posts'),
            'comments' => __('Comments'),
            'likes' => __('Likes'),
        ];

        return inertia('Profile/Index', [
            'posts' => PostResource::collection($user->posts()->with('topic')->paginate()),
            'comments' => $request->when(
                $request->query('section') === 'comments',
                fn () => CommentResource::collection($user->comments()->with('user')->paginate()),
            ),
            'likes' => $request->when(
                $request->query('section') === 'likes',
                fn () => LikeResource::collection($likeables),
            ),
            'section' => $request->query('section'),
            'words' => $t,
        ]);
    }
}
