<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'content'      => $this->content,
            'image'        => $this->image,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
            'user'         => new UserResource(User::find($this->user_id)),
            'category'     => new CategoryResource(Category::find($this->category_id)),
            'comments'     => $this->post_comments_count,
            'likes'        => $this->post_likes_count,
        ];
    }
}
