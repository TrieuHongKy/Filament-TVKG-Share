<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobSalaryResource extends JsonResource{

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
            'min_salary'   => $this->min_salary,
            'max_salary'   => $this->max_salary,
            'fixed_salary' => $this->fixed_salary,
        ];
    }
}
