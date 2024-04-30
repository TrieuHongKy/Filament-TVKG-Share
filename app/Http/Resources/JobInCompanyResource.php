<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobInCompanyResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'              => $this->id,
            'job_detail'      => new JobDetailResource($this->detail),
            'job_type'        => new JobTypeResource($this->jobType),
            'job_status'      => new JobStatusResource($this->jobStatus),
            'job_salary'      => new JobSalaryResource($this->salary),
            'job_requirement' => new JobRequirementResource($this->requirements),
            'job_attribute'   => new JobAttributeResource($this->attribute),
        ];
    }
}
