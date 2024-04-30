<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobAttributeResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'           => $this->id,
            // 'job_id'       => $this->job_id,
            'is_active'    => $this->is_active,
            'is_featured'  => $this->is_featured,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
            'expired_at'   => $this->expired_at,
        ];
    }
}
