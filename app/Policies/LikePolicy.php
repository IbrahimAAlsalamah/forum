<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LikePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Model $likeable): bool
    {
        return $likeable->likes()->whereBelongsTo($user)->doesntExist()
            && in_array($likeable::class, [Post::class, Comment::class]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $likeable): bool
    {
        return $likeable->likes()->whereBelongsTo($user)->exists()
            && in_array($likeable::class, [Post::class, Comment::class]);
    }
}
