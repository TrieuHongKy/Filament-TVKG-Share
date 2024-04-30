<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'             => $this->id,
            'education_name' => $this->education_name,
            'description'    => $this->description,
            'start_date'     => $this->start_date,
            'end_date'       => $this->end_date,
            'major'          => $this->major,
            'institution'    => $this->institution,
            'city'           => $this->city,
            'country'        => $this->country,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
