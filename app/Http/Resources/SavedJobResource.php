<?php

namespace App\Http\Resources;

use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedJobResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'        => $this->id,
            'candidate' => new CandidateResource(Candidate::find($this->candidate_id)),
            'job'       => new JobResource(Job::find($this->job_id)),
        ];
    }
}
