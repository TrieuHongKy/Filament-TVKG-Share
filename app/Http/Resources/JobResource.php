<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource{

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
            'company'         => new CompanyResource($this->company),
            'category'        => new CategoryResource($this->category),
            'province'        => new ProvinceResource(Province::find($this->province_id)),
            'district'        => new DistrictResource(District::find($this->district_id)),
            'ward'            => new WardResource(Ward::find($this->ward_id)),
            'job_type'        => new JobTypeResource($this->jobType),
            'job_status'      => new JobStatusResource($this->jobStatus),
            'job_salary'      => new JobSalaryResource($this->salary),
            'job_requirement' => new JobRequirementResource($this->requirements),
            'job_attribute'   => new JobAttributeResource($this->attribute),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
