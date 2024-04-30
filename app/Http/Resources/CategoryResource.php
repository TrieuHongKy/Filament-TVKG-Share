<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'parent'      => new CategoryResource(Category::find($this->parent_id)),
            'image'       => $this->image,
            'status'      => $this->status,
            'post_count'  => $this->posts_count
            // 'created_at'  => $this->created_at,
            // 'updated_at'  => $this->updated_at
        ];
    }
}
