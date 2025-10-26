<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->likeable_type,
            'likeable' => $this->whenLoaded('likeable', function () {
                if ($this->likeable instanceof Post) {
                    return PostResource::make($this->likeable->load('topic'));
                }
                if ($this->likeable instanceof Comment) {
                    return CommentResource::make($this->likeable->load('user'));
                }

                return null;
            }),
        ];
    }
}
