<?php

namespace App\Http\Resources;

use App\Models\Degree;
use App\Models\Experience;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobRequirementResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'         => $this->id,
            // 'job_id'     => $this->job_id,
            'major'      => new MajorResource(Major::find($this->major_id)),
            'degree'     => new DegreeResource(Degree::find($this->degree_id)),
            'experience' => new ExperienceResource(Experience::find($this->experience_id)),
        ];
    }
}
