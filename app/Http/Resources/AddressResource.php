<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'province'   => new ProvinceResource(Province::find($this->province_id)),
            'district'   => new DistrictResource(District::find($this->district_id)),
            'ward'       => new WardResource(Ward::find($this->ward_id)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
