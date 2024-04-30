<?php

namespace App\Http\Resources;

use App\Models\Major;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'         => $this->id,
            'user'       => new UserResource(User::find($this->user_id)),
            'major'      => new MajorResource(Major::find($this->major_id)),
            'resume'     => new ResumeResource(Resume::find($this->resume_id)),
            'major_name' => $this->major_name,
            'skills'     => SkillResource::collection($this->whenLoaded('skills')),
            'educations' => EducationResource::collection($this->whenLoaded('educations')),
            'languages'  => LanguageResource::collection($this->whenLoaded('languages')),
            'address'    => new AddressResource($this->address),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
