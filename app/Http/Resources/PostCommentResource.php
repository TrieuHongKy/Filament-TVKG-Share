<?php

namespace App\Http\Resources;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCommentResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'      => $this->id,
            'user'    => new UserResource(User::find($this->user_id)),
            //            'post'   => new PostResource(Post::find($this->post_id)),
            'parent'  => new PostCommentResource(PostComment::find($this->parent_id)),
            'comment' => $this->comment,
        ];
    }
}
